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
    public Text txtBtnLogout;
    string email;
    string passWord;
    string stringError;
    public Image background;
    public databaseConnection scriptDatabaseConnection;
    private string idPlayer = "";
    private string namePlayer = "";
    public Text txtName;
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
        if (PlayerPrefs.GetString("loggedIn") == "true") {
            txtError.gameObject.SetActive(false);
            txtPassWord.gameObject.SetActive(false);
            txtEmail.gameObject.SetActive(false);
            background.gameObject.SetActive(false);
            txtTitle.gameObject.SetActive(false);
            inputEmail.gameObject.SetActive(false);
            inputPassword.gameObject.SetActive(false);
            btnLogin.gameObject.SetActive(false);
            scriptDatabaseConnection.isChoosing = true;
            txtName.text = PlayerPrefs.GetString("userName");
        }
        else
        {
            txtName.gameObject.SetActive(false);
            //   returnAnswers();

        }
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
        formAnswers.AddField("user_id", "0");
        //formAnswers.AddField("user_id", PlayerPrefs.GetString("userID"));
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
        stringError = "";
        //Debug.Log("stil working before return");
        yield return www;

        // check for errors
        if (www.error == null)
        {

            Debug.Log("WWW Ok!: " + www.text);
            JsonData dataProjects = JsonMapper.ToObject(www.text);
            
            if (dataProjects["success"].ToString() == "True")
            {
                txtError.gameObject.SetActive(false);
                txtPassWord.gameObject.SetActive(false);
                txtEmail.gameObject.SetActive(false);
                background.gameObject.SetActive(false);
                txtTitle.gameObject.SetActive(false);
                inputEmail.gameObject.SetActive(false);
                inputPassword.gameObject.SetActive(false);
                btnLogin.gameObject.SetActive(false);
                scriptDatabaseConnection.isChoosing = true;

               idPlayer = dataProjects["User"]["id"].ToString();
                PlayerPrefs.SetString("userID", idPlayer);
                namePlayer = dataProjects["User"]["name"].ToString();
                PlayerPrefs.SetString("userName", namePlayer);
                txtName.text = namePlayer;
            }
            else
            {
                foreach (string keyToShow in dataProjects.Keys)
                {
                    if(keyToShow == "User")
                    {
                        stringError += "E-mail of wachtwoord is fout";
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
    }
    public void btnLogoutClicked() //button is logout if logged in, login if logged out
    {
        if(PlayerPrefs.GetString("loggedIn") != "0") { 
        idPlayer = "0";
        namePlayer = "";
        txtName.text = "";
        txtName.gameObject.SetActive(false);
        PlayerPrefs.SetString("userID", "0");
        PlayerPrefs.SetString("userName", "");
            txtBtnLogout.text = "Inloggen";
        }
        else
        {
            txtError.gameObject.SetActive(true);
            txtPassWord.gameObject.SetActive(true);
            txtEmail.gameObject.SetActive(true);
            background.gameObject.SetActive(true);
            txtTitle.text = "Log je hier in";
            txtTitle.gameObject.SetActive(true);
            inputEmail.gameObject.SetActive(true);
            inputPassword.gameObject.SetActive(true);
            btnLogin.gameObject.SetActive(true);

            txtBtnLogout.text = "Uitloggen";
        }
    }

}
