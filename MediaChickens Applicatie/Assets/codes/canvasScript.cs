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
/*    List<GameObject> listPause;
    List<GameObject> listOverallPaused;
    List<GameObject> listOverallPlaying;
    List<GameObject> listPauseAndLogin;
    List<GameObject> listLogin;
    List<GameObject> listEnd;

    */

    void Start () {
  /*      listPause.AddRange(
            { btnContinue.gameObject, btnLogout.gameObject, txtBtnLogout.gameObject}
        );
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

        Debug.Log(listLogin.Find(test => test.name == "txtError"));

    */
        btnPause.gameObject.SetActive(true);

        hideAllPaused();
        toggleLoginLogoutButton();
        changePlayerName();
        showAllPlaying();
    }

    public void showLoginScreen()
    {

        txtEmail.gameObject.SetActive(true);
        txtPassWord.gameObject.SetActive(true);
        txtError.gameObject.SetActive(true);
        inputEmail.gameObject.SetActive(true);
        inputPassword.gameObject.SetActive(true);
        btnLogin.gameObject.SetActive(true);
        btnAnonymous.gameObject.SetActive(true);

    }
    public void showLoginErrors(byte numberOfErrors, string stringErrors)
    {
        if (numberOfErrors > 0)
        {
            errorLogo1.gameObject.SetActive(true);
        }
        if(numberOfErrors > 1)
        {
            errorLogo2.gameObject.SetActive(true);
        }
       
        txtError.text = stringErrors;
    }
    public void showPauseAll()
    {
        //UI for overall use during pause
        background.gameObject.SetActive(true);
        logoEndScreen.gameObject.SetActive(true);
    }
    public void showPauseScreen()
    {
        //overlap Pause and Login, not finished -> finished is when all questions of project are answered, and player gets and end screen
        txtPauseTitle.gameObject.SetActive(true);
        headerPause.gameObject.SetActive(true);
        
        //UI pause
        btnContinue.gameObject.SetActive(true);
        btnLogout.gameObject.SetActive(true);
        txtBtnLogout.gameObject.SetActive(true);
        btnRestart.gameObject.SetActive(true);
    }
    public void showEndScreen()
    {

    }
    public void hideAllPaused()
    {
    //UI for overall use during pause
    background.gameObject.SetActive(false);
    btnRestart.gameObject.SetActive(false);
    logoEndScreen.gameObject.SetActive(false);

    //overlap Pause and Login, not finished -> finished is when all questions of project are answered, and player gets and end screen
    txtPauseTitle.gameObject.SetActive(false);
     headerPause.gameObject.SetActive(false);

    //UI pause
   btnContinue.gameObject.SetActive(false);
     btnLogout.gameObject.SetActive(false);

    //UI for login
    txtEmail.gameObject.SetActive(false);
    txtPassWord.gameObject.SetActive(false);
     txtError.gameObject.SetActive(false);
    inputEmail.gameObject.SetActive(false);
     inputPassword.gameObject.SetActive(false);
     btnLogin.gameObject.SetActive(false);
     btnAnonymous.gameObject.SetActive(false);
    errorLogo1.gameObject.SetActive(false);
     errorLogo2.gameObject.SetActive(false);

    //UI project finished 
     headerAnswered.gameObject.SetActive(false);
     txtAnswered.gameObject.SetActive(false);
}
    public void changePlayerName()
    {
        txtName.text = PlayerPrefs.GetString("userName");
    }
    public void showAllPlaying()
    {
        txtName.gameObject.SetActive(true);
        btnPause.gameObject.SetActive(true);
    }
    public void hideAllPlaying()
    {
        txtName.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(false);
    }
    public void toggleLoginLogoutButton()
    {
        if (PlayerPrefs.GetString("loggedIn") == "true")
        {
            txtBtnLogout.text = "Afmelden";
        }
        else
        {
            txtBtnLogout.text = "Aanmelden";
        }
    } //sets text from button on login when logged out en logout when logged in
	
}
