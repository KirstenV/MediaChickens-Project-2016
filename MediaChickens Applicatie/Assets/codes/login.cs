using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using LitJson;

public class login : MonoBehaviour {

    public Text txtEmail;
    public Text txtPassWord;
    public Text txtError;
    public Text txtTitle;
    public InputField inputEmail;
    public InputField inputPassword;
    public Button btnLogin;
    public Button btnAnonymous;
    public Text txtBtnLogout;
    public Text txtName;
    public Image background;
    public RawImage errorLogo1;
    public RawImage errorLogo2;

    string email;
    string passWord;
    string stringError;

    databaseConnection scriptDatabaseConnection;
    canvasScript scriptCanvas;
    private string idPlayer = "";
    private string namePlayer = "";

    private string currentAnswer = "";
    private byte answerCount = 0;
    private string answerID = "";
    string urlLogin = "http://mediachickens.multimediatechnology.be/unity/login";
    string urlReturnAnswers = "http://mediachickens.multimediatechnology.be/unity/answers";
    WWWForm form;
    WWWForm formAnswers;
    WWW wwwAnswers;
    WWW www;
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
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer2;
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer3;
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "AnswerD")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].stringAnswer4;
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "NoAnswer")
        {
            currentAnswer = "geen mening";
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
    }
    private void returnAnswers(string playerAnswered, string questionID)
    {
        formAnswers = new WWWForm();
        formAnswers.AddField("antwoorden", playerAnswered);
        formAnswers.AddField("vragen_id", questionID);
        formAnswers.AddField("user_id", PlayerPrefs.GetString("userID"));
        wwwAnswers = new WWW(urlReturnAnswers, formAnswers);
        StartCoroutine(answerReturnRequest(wwwAnswers));
    }
    private void checkUser()
    {
        form = new WWWForm();
        form.AddField("email", email);
        form.AddField("password", passWord);
        www = new WWW(urlLogin, form);
        StartCoroutine(WaitForRequest(www));
    }

    IEnumerator answerReturnRequest(WWW www)
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

    IEnumerator WaitForRequest(WWW www)
    {
        errorLogo1.gameObject.SetActive(false);
        errorLogo2.gameObject.SetActive(false);
        stringError = "";
        yield return www;

        // check for errors
        if (www.error == null)
        {

            Debug.Log("WWW Ok!: " + www.text);
            JsonData dataProjects = JsonMapper.ToObject(www.text);
            
            if (dataProjects["success"].ToString() == "True")
            {
                inputEmail.gameObject.SetActive(false);
                inputPassword.gameObject.SetActive(false);
                txtError.gameObject.SetActive(false);
                txtPassWord.gameObject.SetActive(false);
                txtEmail.gameObject.SetActive(false);
                btnLogin.gameObject.SetActive(false);
                idPlayer = dataProjects["User"]["id"].ToString();
                PlayerPrefs.SetString("userID", idPlayer);
                namePlayer = dataProjects["User"]["name"].ToString();
                if(namePlayer == "Anonymous")
                {
                    PlayerPrefs.SetString("userName", "");
                }
                else
                {
                    PlayerPrefs.SetString("userName", namePlayer);
                }
                txtName.text = namePlayer;
                btnAnonymous.gameObject.SetActive(false);
                scriptDatabaseConnection.BtnPauseClicked();
            }
            else
            {
                foreach (string keyToShow in dataProjects.Keys)
                {
                    if(keyToShow == "User")
                    {
                        errorLogo1.gameObject.SetActive(true);
                        stringError +=  "E-mail of wachtwoord is fout";
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
                txtError.text = stringError;
            }
        }
        else
        {
            Debug.Log("WWW Error: " + www.error);
        }
    }
    public void btnLoginClicked()
    {
        email = txtEmail.text;
        passWord = txtPassWord.text;
        checkUser();
        PlayerPrefs.SetString("loggedIn", "true");
        
    }
    public void btnLogoutClicked() //button is logout if logged in, login if logged out
    {
        scriptDatabaseConnection.setPauseScreenInactive();
        if (PlayerPrefs.GetString("loggedIn") == "true") { //log out

            btnAnonymousClicked();
        }
        else
        { //change backgrounds
            txtError.gameObject.SetActive(true);
            txtPassWord.gameObject.SetActive(true);
            txtEmail.gameObject.SetActive(true);
            background.gameObject.SetActive(true);
            txtTitle.text = "LOG IN";
            txtTitle.gameObject.SetActive(true);
            inputEmail.gameObject.SetActive(true);
            inputPassword.gameObject.SetActive(true);
            btnLogin.gameObject.SetActive(true);
            btnAnonymous.gameObject.SetActive(true);
           // txtBtnLogout.text = "Uitloggen";
        }
    }
    public void btnAnonymousClicked()
    {
        txtName.gameObject.SetActive(false);
      
     //   txtBtnLogout.text = "Inloggen";
        email = "unknown@anonymous.anonymous";
        passWord = "123456";
        checkUser();
        
        PlayerPrefs.SetString("loggedIn", "false");
        scriptCanvas.showAllPlaying();
        scriptDatabaseConnection.BtnPauseClicked();
        btnAnonymous.gameObject.SetActive(false);
    }
    

}
