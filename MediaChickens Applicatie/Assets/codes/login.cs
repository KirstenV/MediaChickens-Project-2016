using UnityEngine;
using System.Collections;
using LitJson;

public class login : MonoBehaviour {
    //link to other scripts
    databaseConnection scriptDatabaseConnection;
    canvasScript scriptCanvas;

    //variables to be filled with input from user and send to database
    private string email; 
    private string passWord;

    //variables for anonymous login
    private string emailAnonymous = "Unknown@anonymous.anonymous";
    private string passwordAnonymous = "123456";
    //string with errors to be showed when login failed
    private string stringError;

    //the info from player returned from database
    private string idPlayer = "";
    private string namePlayer = "";

    //variables to register the answer of the user and send it to database
    private string currentAnswer = "";
    public byte answerCount = 0;
    private string answerID = "";

    //variables for connection database - login
    private WWWForm formLogin;
    private WWW wwwLogin;
    private string urlLogin = "http://mediachickens.multimediatechnology.be/unity/login";

    //variables for connection database - answers
    private string urlReturnAnswers = "http://mediachickens.multimediatechnology.be/unity/answers";
    private WWWForm formAnswers;
    private WWW wwwAnswers;

    void Start()
    {
        if(PlayerPrefs.GetString("firstTimePlayed") == "") //if this is the first time player opens app, player is set to anonymous
        {
            btnAnonymousClicked();
            PlayerPrefs.SetString("firstTimePlayed", "false");
        }

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
        fillAnswerForm(currentAnswer, answerID);
    } //the user has given his answer, variables are filled in and sent to database
    private void fillAnswerForm(string playerAnswered, string questionID)
    {
        formAnswers = new WWWForm();
        formAnswers.AddField("antwoorden", playerAnswered);
        formAnswers.AddField("vragen_id", questionID);
        formAnswers.AddField("user_id", PlayerPrefs.GetString("userID"));
        wwwAnswers = new WWW(urlReturnAnswers, formAnswers);
        StartCoroutine(sendAnswerToDatabase(wwwAnswers));
    } //form is filled and answers sent to database
    IEnumerator sendAnswerToDatabase(WWW www) //answer is sent to database
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
    }//sent answer to the database

    private void fillUserForm() 
    {
        formLogin = new WWWForm();
        formLogin.AddField("email", email);
        formLogin.AddField("password", passWord);
        wwwLogin = new WWW(urlLogin, formLogin);
        StartCoroutine(sendLoginToDatabase(wwwLogin));
    } //form is filled and login sent to database
    IEnumerator sendLoginToDatabase(WWW www)
    {
        stringError = "";
        yield return www;

        // check for errors
        if (www.error == null)
        {
            JsonData dataProjects = JsonMapper.ToObject(www.text); //make json object from info database returned
            
            if (dataProjects["success"].ToString() == "True") //if user exists, add data and start game
            {
                scriptCanvas.hideAllPaused();
                idPlayer = dataProjects["User"]["id"].ToString();
                PlayerPrefs.SetString("userID", idPlayer);
                namePlayer = dataProjects["User"]["name"].ToString();
             //   Debug.Log(dataProjects["User"][1].ToString());
                if(namePlayer == emailAnonymous)
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
            else //if login failed
            {
                foreach (string keyToShow in dataProjects.Keys)
                {
                    if(keyToShow == "User") //email or password not in database
                    {
                        stringError +=  "E-mail of wachtwoord is fout";
                        scriptCanvas.showLoginErrors(1, stringError); //always 1 error
                    }
                    else if(keyToShow == "errors") //syntax errors
                    {
                        
                        for (int i = 0; i < dataProjects["errors"].Count; i++)
                        {

                            for (int j = 0; j < dataProjects["errors"][i].Count; j++) //for each error, add it to the string
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
    } //sent login to database and check if user exists or is anonymous
    public void btnLoginClicked()
    {
        email = scriptCanvas.getInputEmail();
        passWord = scriptCanvas.getInputPassword();
        fillUserForm();
    } //user clicked the login, check user in database
    public void btnLogoutClicked() 
    {
        Debug.Log("button logout clicked");
        scriptCanvas.hideAllPaused();
        if (PlayerPrefs.GetString("loggedIn") == "true") { //log out
            btnAnonymousClicked();
        }
        else //log in
        { 
            scriptCanvas.showLoginScreen();
        }
    }//button is logout if logged in, login if logged out
    public void btnAnonymousClicked()
    {
        email = emailAnonymous; //set in different var
        passWord = passwordAnonymous;
        fillUserForm(); 
    } //gets anonymous user from database
    

}
