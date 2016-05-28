using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using LitJson;

public class login : MonoBehaviour {
    //link to other scripts
    databaseConnection scriptDatabaseConnection;
    canvasScript scriptCanvas;

    //variables to be filled with input from user and send to database
    string email; 
    string passWord;

    //string with errors to be showed when login failed
    string stringError;

    //the info from player returned from database
    private string idPlayer = "";
    private string namePlayer = "";

    //variables to register the answer of the user and send it to database
    private string currentAnswer = "";
    private byte answerCount = 0;
    private string answerID = "";

    //variables for connection database - login
    WWWForm formLogin;
    WWW wwwLogin;
    string urlLogin = "http://mediachickens.multimediatechnology.be/unity/login";

    //variables for connection database - answers
    string urlReturnAnswers = "http://mediachickens.multimediatechnology.be/unity/answers";
    WWWForm formAnswers;
    WWW wwwAnswers;

    void Start()
    {
        scriptDatabaseConnection = GetComponent<databaseConnection>();
        scriptCanvas = GetComponent<canvasScript>();
    }
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.tag == "AnswerA")
        {
           currentAnswer =  scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer1;
            answerGiven();
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer2;
            answerGiven();
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer3;
            answerGiven();
        }
        else if (other.gameObject.tag == "AnswerD")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer4;
            answerGiven();
        }
        else if (other.gameObject.tag == "NoAnswer")
        {
            currentAnswer = "geen mening";
            answerGiven();
        }
    } //triggers the right answer and sends the answer to database

    private void answerGiven()
    {
        answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
        answerCount++;
        returnAnswers(currentAnswer, answerID);
        Debug.Log(currentAnswer);
    }
    private void returnAnswers(string playerAnswered, string questionID)
    {
        formAnswers = new WWWForm();
        formAnswers.AddField("antwoorden", playerAnswered);
        formAnswers.AddField("vragen_id", questionID);
        formAnswers.AddField("user_id", PlayerPrefs.GetString("userID"));
        wwwAnswers = new WWW(urlReturnAnswers, formAnswers);
        StartCoroutine(sendAnswerToDatabase(wwwAnswers));
    }
    private void checkUser()
    {
        formLogin = new WWWForm();
        formLogin.AddField("email", email);
        formLogin.AddField("password", passWord);
        wwwLogin = new WWW(urlLogin, formLogin);
        StartCoroutine(sendLoginToDatabase(wwwLogin));
    }

    IEnumerator sendAnswerToDatabase(WWW www)
    {
        yield return www;

        // check for errors
        if (www.error == null)
        {
            Debug.Log("WWW Ok!: " + www.text);
           // JsonData dataProjects = JsonMapper.ToObject(www.text); 
        }
        else
        {
            Debug.Log("WWW Error: " + www.error);
        }
    }

    IEnumerator sendLoginToDatabase(WWW www)
    {
        stringError = "";
        yield return www;

        // check for errors
        if (www.error == null)
        {

            Debug.Log("WWW Ok!: " + www.text);
            JsonData dataProjects = JsonMapper.ToObject(www.text);
            
            if (dataProjects["success"].ToString() == "True")
            {
                scriptCanvas.hideAllPaused();
                idPlayer = dataProjects["User"]["id"].ToString();
                PlayerPrefs.SetString("userID", idPlayer);
                namePlayer = dataProjects["User"]["name"].ToString();
                if(namePlayer == "Anonymous")
                {
                    PlayerPrefs.SetString("userName", "");
                    PlayerPrefs.SetString("loggedIn", "false");
                }
                else
                {
                    PlayerPrefs.SetString("userName", namePlayer);
                    PlayerPrefs.SetString("loggedIn", "true");
                }
                scriptCanvas.changePlayerName();
                scriptCanvas.showAllPlaying();
                scriptCanvas.toggleLoginLogoutButton();
            }
            else
            {
                foreach (string keyToShow in dataProjects.Keys)
                {
                    if(keyToShow == "User")
                    {
                        stringError +=  "E-mail of wachtwoord is fout";
                        scriptCanvas.showLoginErrors(1, stringError); //hier altijd maar 1 error
                    }
                    else if(keyToShow == "errors")
                    {
                        
                        for (int i = 0; i < dataProjects["errors"].Count; i++)
                        {

                            for (int j = 0; j < dataProjects["errors"][i].Count; j++)
                            {
                                stringError += dataProjects["errors"][i][j] + "\n";
                            }
                        }
                        scriptCanvas.showLoginErrors((byte)dataProjects["errors"].Count, stringError);
                    }
                }
            }
        }
        else
        {
            
            Debug.Log("WWW Error: " + www.error);
        }
    }
    public void btnLoginClicked()
    {
        email = scriptCanvas.getInputEmail();
        passWord = scriptCanvas.getInputPassword();
        checkUser();
        
    }
    public void btnLogoutClicked() //button is logout if logged in, login if logged out
    {
        Debug.Log(PlayerPrefs.GetString("loggedIn"));
        scriptCanvas.hideAllPaused();
        if (PlayerPrefs.GetString("loggedIn") == "true") { //log out
            btnAnonymousClicked();
        }
        else
        { 
            scriptCanvas.showLoginScreen();
        }
    }
    public void btnAnonymousClicked()
    {
        email = "unknown@anonymous.anonymous"; //set in different var
        passWord = "123456";
        checkUser(); 
    }
    

}
