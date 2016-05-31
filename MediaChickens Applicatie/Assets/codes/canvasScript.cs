using UnityEngine;
using UnityEngine.UI;

public class canvasScript : MonoBehaviour { 
    //script for all UI except textMeshes

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

    //swipeControl script so swipe is not registered when game is paused
    swipeControls scriptSwipe;

    void Start () {
        scriptSwipe = GetComponent<swipeControls>();
        hideAllPaused(); //hides the pause screen and shows the game interface
        toggleLoginLogoutButton(); //shows the right text on the login/logout button in the pause screen
        changePlayerName(); //fills the text with the right player name
        txtAnswered.text = "alle vragen zijn beantwoord".ToUpper();
    }

    public void showLoginScreen()
    {
        txtPauseTitle.text = "log in".ToUpper();
        showPauseAll();
        txtEmail.gameObject.SetActive(true);
        txtPassWord.gameObject.SetActive(true);
        txtError.gameObject.SetActive(true);
        inputEmail.gameObject.SetActive(true);
        inputPassword.gameObject.SetActive(true);
        btnLogin.gameObject.SetActive(true);
        btnAnonymous.gameObject.SetActive(true);
        txtPauseTitle.gameObject.SetActive(true);
        headerPause.gameObject.SetActive(true);
    } //shows the login screen
    public void showLoginErrors(byte numberOfErrors, string stringErrors)
    {
        hideLoginErrors(); //resets the errors
        errorLogo1.gameObject.SetActive(true);
        if(numberOfErrors > 1) //if there are more than 1 error, 2 error signs must be showed
        {
            errorLogo2.gameObject.SetActive(true);
        }
       
        txtError.text = stringErrors;
    } //shows and fills the login errors
    public void hideLoginErrors()
    {
        txtError.text = "";
        errorLogo1.gameObject.SetActive(false);
        errorLogo2.gameObject.SetActive(false);
    } //hides the login errors
    void showPauseAll()
    {
        scriptSwipe.gamePaused = true;
        background.gameObject.SetActive(true);
        logoEndScreen.gameObject.SetActive(true);
        hideAllPlaying();
    } //shows the elements all paused screens have (background, logo) and hides the game interface
    public void showPauseScreen(bool isPlaying)
    {
        Debug.Log("paused");
        txtPauseTitle.text = "pauze".ToUpper(); 
        showPauseAll();
        //overlap Pause and Login, not finished -> finished is when all questions of project are answered, and player gets and end screen
        txtPauseTitle.gameObject.SetActive(true);
        headerPause.gameObject.SetActive(true);
        
        //UI pause
        btnLogout.gameObject.SetActive(true);
        txtBtnLogout.gameObject.SetActive(true);
        btnRestart.gameObject.SetActive(true);

        if(isPlaying) //if player is in game, the continue button is available, if player is choosing project, continue button is not available
        {
            btnContinue.gameObject.SetActive(true);
        }
    } //shows the basic paused screen
    public void showEndScreen()
    {
        showPauseAll();
        btnRestart.gameObject.SetActive(true);
        headerAnswered.gameObject.SetActive(true);
        txtAnswered.gameObject.SetActive(true);
    } //shows the screen when all questions are answered
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
    txtPassWord.text = "";
    hideLoginErrors();
    inputEmail.gameObject.SetActive(false);
    inputPassword.gameObject.SetActive(false);
    btnLogin.gameObject.SetActive(false);
    btnAnonymous.gameObject.SetActive(false);


    //UI project finished 
     headerAnswered.gameObject.SetActive(false);
     txtAnswered.gameObject.SetActive(false);
     showAllPlaying();

    //activate swipe controls 
     scriptSwipe.gamePaused = false;

    } //hides all components used during pause screens (end screen, paused and login)
    public void changePlayerName()
    {
        txtName.text = PlayerPrefs.GetString("userName");
    } //changes the players name on the screen
    public void showAllPlaying()
    {
        txtName.gameObject.SetActive(true);
        btnPause.gameObject.SetActive(true);
    } //shows the gaming interface
    public void hideAllPlaying()
    {
        txtName.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(false);
    } //hides the gaming interface
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
	public string getInputEmail()
    {
        return inputEmail.text;
    } //gets the email user filled in
    public string getInputPassword()
    {
        return inputPassword.text;
    } //gets the password user filled in
}
