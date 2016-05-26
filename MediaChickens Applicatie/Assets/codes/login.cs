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
        Debug.Log(idPlayer);
        txtError.gameObject.SetActive(true);
        txtPassWord.gameObject.SetActive(true);
        txtEmail.gameObject.SetActive(true);
        background.gameObject.SetActive(true);
        txtTitle.text = "Log je hier in";
        txtTitle.gameObject.SetActive(true);
        inputEmail.gameObject.SetActive(true);
        inputPassword.gameObject.SetActive(true);
        btnLogin.gameObject.SetActive(true);
        scriptDatabaseConnection = GetComponent<databaseConnection>();
     //   returnAnswers();
    }
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.tag == "AnswerA")
        {
           currentAnswer =  scriptDatabaseConnection.arrQuestions[answerCount].possibility1;
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].possibility2;
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].possibility3;
            answerID = scriptDatabaseConnection.arrQuestions[answerCount].id;
            answerCount++;
            Debug.Log(currentAnswer);
            returnAnswers(currentAnswer, answerID);
        }
        else if (other.gameObject.tag == "AnswerD")
        {
            currentAnswer = scriptDatabaseConnection.arrQuestions[answerCount].possibility4;
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
        formAnswers.AddField("user_id", idPlayer);
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
                namePlayer = dataProjects["User"]["name"].ToString();
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

}
