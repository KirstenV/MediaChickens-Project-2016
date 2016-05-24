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

    string urlLogin = "http://mediachickens.multimediatechnology.be/unity/login";
    string urlReturnAnswers = "http://mediachickens.multimediatechnology.be/unity/answers";
    WWWForm form;
    WWWForm formAnswers;
    WWW wwwAnswers;
    WWW www;
    void Start()
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
        scriptDatabaseConnection = GetComponent<databaseConnection>();
     //   returnAnswers();
    }

    private void returnAnswers()
    {
        formAnswers = new WWWForm();
        formAnswers.AddField("antwoorden", "test");
        formAnswers.AddField("vragen_id", "20");
        formAnswers.AddField("user_id", "lel");
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
        Debug.Log("stil working before return");
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
            }
            else
            {
                Debug.Log(dataProjects["User"]);
                if (dataProjects["User"].ToString() == "Gebruiker bestaat niet")
                {
                    stringError = "E-mail of wachtwoord is fout";
                }
                else { 
                stringError = "";
                for (int i = 0; i < dataProjects["errors"].Count; i++)
                {

                    for (int j = 0; j < dataProjects["errors"][i].Count; j++)
                    {
                        stringError += dataProjects["errors"][i][j] + "\n";
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
