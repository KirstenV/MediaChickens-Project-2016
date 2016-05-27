using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using UnityEngine.UI;

public class canvasScript : MonoBehaviour { 
    //script for all UI exept textMeshes

    //UI for overall use (all paused screens)
    public Image background;
    public Button btnRestart;
    public RawImage logoEndScreen;

    //UI for overall use (during playing)
    public Button btnPause;
    public Text txtName;

    //overlap Pause and Login, not finished -> finished is when all questions of project are answered, and player gets and end screen
    public Text txtPauseTitle;
    public Image headerPause;

    //UI pause
    public Button btnContinue;
    public Button btnLogout;
    public Text txtBtnLogout;

    //UI for login
    public Text txtEmail;
    public Text txtPassWord;
    public Text txtError;
    public InputField inputEmail;
    public InputField inputPassword;
    public Button btnLogin;
    public Button btnAnonymous;
    public RawImage errorLogo1;
    public RawImage errorLogo2;

    //UI project finished 
    public Image headerAnswered;
    public Text txtAnswered;

    //arrays with gameobject for easier looping through
    // public GameObject[] arrAllInterfaceObjects =  { background.gameObject , btnRestart.gameObject};
    List<GameObject> listPause;
    List<GameObject> listOverallPaused;
    List<GameObject> listOverallPlaying;
    List<GameObject> listPauseAndLogin;
    List<GameObject> listLogin;
    List<GameObject> listEnd;








    // Use this for initialization
    void Start () {
        listPause = new List<GameObject>();
        listPause.AddRange(GameObject.FindGameObjectsWithTag("UIPause"));
        listOverallPaused = new List<GameObject>();
        listOverallPaused.AddRange(GameObject.FindGameObjectsWithTag("UIAllPaused"));
        listOverallPlaying = new List<GameObject>();
        listOverallPlaying.AddRange(GameObject.FindGameObjectsWithTag("UIAllPlaying"));
        listPauseAndLogin = new List<GameObject>();
        listPauseAndLogin.AddRange(GameObject.FindGameObjectsWithTag("UIPauseAndLogin"));
        listLogin = new List<GameObject>();
        listLogin.AddRange(GameObject.FindGameObjectsWithTag("UILogin"));
        listEnd = new List<GameObject>();
        listEnd.AddRange(GameObject.FindGameObjectsWithTag("UIEnd"));



        headerAnswered.gameObject.SetActive(false);
        headerPause.gameObject.SetActive(false);
        btnRestart.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(true);
        //   bgEndScreen.gameObject.SetActive(false);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(false);
        btnContinue.gameObject.SetActive(false);
        //  txtPause.gameObject.SetActive(false);
        btnLogout.gameObject.SetActive(false);
        txtPauseTitle.gameObject.SetActive(false);
        errorLogo1.gameObject.SetActive(false);
        errorLogo2.gameObject.SetActive(false);
        txtError.gameObject.SetActive(false);
        txtPassWord.gameObject.SetActive(false);
        txtEmail.gameObject.SetActive(false);
        background.gameObject.SetActive(false);
        inputEmail.gameObject.SetActive(false);
        inputPassword.gameObject.SetActive(false);
        btnLogin.gameObject.SetActive(false);

        if (PlayerPrefs.GetString("loggedIn") == "true")
        {
            txtBtnLogout.text = "Afmelden";
            txtName.text = PlayerPrefs.GetString("userName");
        }
        else
        {
            txtBtnLogout.text = "Aanmelden";
            txtName.gameObject.SetActive(false);
            txtName.text = "";
        }
    }
	
}
