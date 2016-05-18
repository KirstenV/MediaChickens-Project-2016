using UnityEngine;
using UnityEngine.UI;
//JSON
using System.Collections;
using System.Collections.Generic;
using LitJson;

public class databaseConnection : MonoBehaviour {
    public bool isPlaying = false;
    //variables for swipe
    private Touch initialTouchSwipe = new Touch();
    private float distanceSwipe = 0;
    private bool hasSwiped = false;

    //variables for database connection
    string urlProjects = "http://mediachickens.multimediatechnology.be/unity/al_projecten/api"; //url of json to be decoded
    ObjectJSONProjects[] arrProjects;
    ObjectJSONQuestions[] arrQuestions;

    //variables for project choice
    byte currentProject = 0; //change when user choose projects is added
    public TextMesh txtProjectName;

    //button to restart the game + background on canvas
    public Button btnRestart;
    public Image bgEndScreen;
    public RawImage logoEndScreen;
    public Text txtAnswered;
    public Button btnPause;
    public Button btnContinue;
    public Text txtPause;

    //list of answers
    Queue<char> playerAnswers = new Queue<char>();
    byte answerCount;
    //text from question and possible answers
    public TextMesh txtQuestion;
    public TextMesh txtAnswer1;
    public TextMesh txtAnswer2;
    public TextMesh txtAnswer3;
    public TextMesh txtAnswer4;
    public TextMesh txtnoAnswer;
    public GameObject txtOnTunnels;

    //spawning roads and text object
    private float spawnDistance = 200;

    //script of player to change is running
    Player playerScript;


    void Start () {
        StartCoroutine(getProjectsFromURL(urlProjects));
        playerScript = GetComponent<Player>();
        txtProjectName.text = "swipe left and right \n to choose project";
        btnPause.GetComponent<Button>();
        btnContinue.GetComponent<Button>();
        btnPause.onClick.AddListener(() => { BtnPauseClicked(); });
        btnContinue.onClick.AddListener(() => { BtnContinueClicked(); });
        btnRestart.gameObject.SetActive(false);
        bgEndScreen.gameObject.SetActive(false);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(false);
        btnContinue.gameObject.SetActive(false);
        txtPause.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(true);
        answerCount = 0;
    }
    void OnTriggerEnter(Collider other)
    {

        if (other.gameObject.tag == "AnswerA")
        {
            answerCount++;
            playerAnswers.Enqueue('A');
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            answerCount++;
            playerAnswers.Enqueue('B');
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            answerCount++;
            playerAnswers.Enqueue('C');
        }
        if (other.gameObject.tag == "StartGame")
        {
            txtAnswer1.text = arrQuestions[answerCount].possibility1;
            txtnoAnswer.text = "geen antwoord";
        }
    }

    void FixedUpdate() //always being called
    {
        if (!isPlaying) {
            foreach (Touch t in Input.touches)
            {
                if (t.phase == TouchPhase.Began)
                {
                    initialTouchSwipe = t;
                }
                else if (t.phase == TouchPhase.Moved && !hasSwiped)
                {
                    //distance formula
                    float deltaXSwipe = initialTouchSwipe.position.x - t.position.x;
                    float deltaYSwipe = initialTouchSwipe.position.y - t.position.y;
                    distanceSwipe = Mathf.Sqrt((deltaXSwipe * deltaXSwipe) + (deltaYSwipe * deltaYSwipe));
                    //direction
                    bool swipedSideways = Mathf.Abs(deltaXSwipe) > Mathf.Abs(deltaYSwipe); //swipe up and down or sideways
                    if (distanceSwipe > 100)//100
                    {
                        if (swipedSideways && deltaXSwipe > 0) //swiped left
                        {
                            if (currentProject == 0)
                                {
                                    currentProject = (byte)(arrProjects.Length - 1);
                                }
                                else
                                {
                                    currentProject--;
                                }

                                txtProjectName.text = arrProjects[currentProject].title;
                            }
                        else if (swipedSideways && deltaXSwipe <= 0) //swiped right
                        {
                                if (currentProject == (byte)(arrProjects.Length - 1))
                                {
                                    currentProject = 0;
                                }
                                else
                                {
                                    currentProject++;
                                }
                                txtProjectName.text = arrProjects[currentProject].title;
                            
                        }
                        else if (!swipedSideways && deltaYSwipe <= 0) //swiped up
                        {
                        isPlaying = true;
                        StartCoroutine(getQuestionsFromURL(getQuestionsUrl(arrProjects[currentProject].id.ToString()))); //getting questions once player has chosen project
                        playerScript.isRunning = true;
                        playerScript.hasSwipedUp = true;
                    }
                        hasSwiped = true;
                    }
                }
                else if (t.phase == TouchPhase.Ended)
                {
                    initialTouchSwipe = new Touch(); //reset touch
                    hasSwiped = false;
                }
            }
        }
        
    }
    void OnTriggerExit(Collider other)
    {
        if (other.gameObject.tag == "Tunnel")
        {
            if (answerCount == arrQuestions.Length || arrQuestions[answerCount] == null) // if the player has answered all questions
            {
                isPlaying = false;
                bgEndScreen.gameObject.SetActive(true);
                btnRestart.gameObject.SetActive(true);
                txtAnswered.gameObject.SetActive(true);
            }
            else
            {
                if (other.gameObject.tag == "Tunnel")
                {
                    txtAnswer1.text = arrQuestions[answerCount].possibility1;
                    txtAnswer2.text = arrQuestions[answerCount].possibility1;
                    txtAnswer3.text = arrQuestions[answerCount].possibility1;
                    txtAnswer4.text = arrQuestions[answerCount].possibility1;
                    txtQuestion.text = arrQuestions[answerCount].possibility1;
                    txtOnTunnels.transform.position = new Vector3(txtOnTunnels.transform.position.x, txtOnTunnels.transform.position.y, txtOnTunnels.transform.position.z + spawnDistance);
                }
            }
        }
    }
    
    public class ObjectJSONProjects //type of objects with info for projects
    {
        //{"id":10,"titel":"W<CW<C","beschrijving":"klick op mij en pas mij aan voor de beschrijving",
        //"begin_datum":"0000-00-00","eind_datum":"0000-00-00","project_picture":"proef_proef.jpg",
        //"user_id":"1","deleted_at":null,"created_at":"2016-05-13 07:40:35","updated_at":"2016-05-13 07:40:35"}
        string jID;
        string projectTitle;
        string projectDescription;


        public ObjectJSONProjects() { } //empty for default
        public ObjectJSONProjects(string tID, string tTitle, string tDescription)
        {
            jID = tID;
            projectTitle = tTitle;
            projectDescription = tDescription;
        }

        public string id
        {
            get
            {
                return jID;
            }
        }
        public string title
        {
            get
            {
                return projectTitle;
            }
        }
        public string description
        {
            get
            {
                return projectDescription;
            }
        }

    }

    public class ObjectJSONQuestions //objects with info for questions
    {
        string qID;
        string typeOfQuestion;
        string qQuestion;
        string possibleAnswers1, possibleAnswers2, possibleAnswers3, possibleAnswers4;
        public ObjectJSONQuestions() { } //empty for default
        public ObjectJSONQuestions(string tID, string tType, string tQuestion, string tPossibleAnswers1, string tPossibleAnswers2, string tPossibleAnswers3, string tPossibleAnswers4)
        {
            qID = tID;
            typeOfQuestion = tType;
            qQuestion = tQuestion;
            possibleAnswers1 = addPossibleAnswer(tPossibleAnswers1);
            possibleAnswers2 = addPossibleAnswer(tPossibleAnswers2);
            possibleAnswers3 = addPossibleAnswer(tPossibleAnswers3);
            possibleAnswers4 = addPossibleAnswer(tPossibleAnswers4);
        }
        public string id
        {
            get
            {
                return qID;
            }
        }
        public string type
        {
            get
            {
                return typeOfQuestion;
            }
        }
        public string question
        {
            get
            {
                return qQuestion;
            }
        }
        public string possibility1
        {
            get
            {
                return possibleAnswers1;
            }
        }
        public string possibility2
        {
            get
            {
                return possibleAnswers2;
            }
        }
        public string possibility3
        {
            get
            {
                return possibleAnswers3;
            }
        }
        public string possibility4
        {
            get
            {
                return possibleAnswers4;
            }
        }
        private string addPossibleAnswer(string possibleAnswer)
        {
            if (possibleAnswer.Length > 15) // doesn't fit in screen any more
            {
                int lettersOnLine = 0;
                string stringToReturn = "";
                string[] wordsInAnswer = possibleAnswer.Split(' ');
                for (int i = 0; i < wordsInAnswer.Length; i++)
                {
                   lettersOnLine += wordsInAnswer[i].Length;
                    if(lettersOnLine >= 8)
                    {
                        stringToReturn += " " + wordsInAnswer[i] + "\n";
                        lettersOnLine = 0;
                    }
                    else
                    {
                        stringToReturn += " " + wordsInAnswer[i];
                    }
                }
                return stringToReturn;
            }
            else
            {
                return possibleAnswer;
            }
        }
    }

   

    private string getQuestionsUrl(string projectID)
    {
        string urlPart1 = "http://mediachickens.multimediatechnology.be/unity/vragen/";
        string urlPart2 = "/api";
        return urlPart1 + projectID + urlPart2;
    } //makes the url for getting the questions from the chosen project


    public IEnumerator getProjectsFromURL(string projectUrl)
    {
        WWW wwwProjects = new WWW(projectUrl);
        yield return wwwProjects;
        if (wwwProjects.error == null)
        {
            
            addProjectsToArray(wwwProjects.text);
        }
        else
        {
            Debug.Log("ERROR: " + wwwProjects.error);
        }
    }
    IEnumerator getQuestionsFromURL(string urlQuestions)
    { 
        WWW wwwQuestions = new WWW(urlQuestions);

        yield return wwwQuestions;
        // yield return wwwQuestions;
        if (wwwQuestions.error == null)
        {
            addQuestionsToArray(wwwQuestions.text);
        }
        else
        {
            Debug.Log("ERROR: " + wwwQuestions.error);
        }

    }
    private void addProjectsToArray(string jsonString) // jsonstring
    {

        JsonData dataProjects = JsonMapper.ToObject(jsonString);
        arrProjects = new ObjectJSONProjects[dataProjects.Count];
        for (int i = 0; i < dataProjects.Count; i++)
        {
            arrProjects[i] = new ObjectJSONProjects(dataProjects[i]["id"].ToString(), dataProjects[i]["titel"].ToString(), dataProjects[i]["beschrijving"].ToString()); // json object oproepen door (id)
        }

        //hierbij nog aanpassen!!!!! geen return meer geven
    }

    private void addQuestionsToArray(string jsonString) // adding the chosen questions to an array, ready for showing on tunnels
    {

        JsonData dateQuestion = JsonMapper.ToObject(jsonString);
        arrQuestions = new ObjectJSONQuestions[dateQuestion.Count];
        for (int i = 0, j = 0; i < dateQuestion.Count; i++, j++)
        {
            if (dateQuestion[i]["choices"].ToString() != "open vragen")
            {
                arrQuestions[j] = new ObjectJSONQuestions(
                        dateQuestion[i]["id"].ToString(), //string tID
                        dateQuestion[i]["choices"].ToString(), //Type
                        dateQuestion[i]["vraag"].ToString(), //question
                        dateQuestion[i]["mogelijke_antwoorden_1"].ToString(), //possibility1
                        dateQuestion[i]["mogelijke_antwoorden_2"].ToString(), //possibility2
                        dateQuestion[i]["mogelijke_antwoorden_3"].ToString(), //possibility3
                        dateQuestion[i]["mogelijke_antwoorden_4"].ToString() //possibility4
                        );
                //string tQuestion, string tPossibleAnswers1, string tPossibleAnswers2, string tPossibleAnswers3, string tPossibleAnswers4

            }
            else
            {
                j--;
            }
        }
    }
    void BtnPauseClicked()
    {
        isPlaying = false;
        bgEndScreen.gameObject.SetActive(true);
        btnRestart.gameObject.SetActive(true);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(true);
        btnPause.gameObject.SetActive(false);
        btnContinue.gameObject.SetActive(true);
        txtPause.gameObject.SetActive(true);
    }
    void BtnContinueClicked()
    {
        isPlaying = true;
        bgEndScreen.gameObject.SetActive(false);
        btnRestart.gameObject.SetActive(false);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(true);
        btnContinue.gameObject.SetActive(false);
        txtPause.gameObject.SetActive(false);
    }
}

