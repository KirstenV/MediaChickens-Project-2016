using UnityEngine;
using UnityEngine.UI;
//JSON
using System.Collections;
using System.Collections.Generic;
using LitJson;

public class databaseConnection : MonoBehaviour {
    public bool isPlaying = false;
    public bool isChoosing = false;
    //variables for swipe
    private Touch initialTouchSwipe = new Touch();
    private float distanceSwipe = 0;
    private bool hasSwiped = false;

    //roadSpawn
    public GameObject tunnel4;
    public GameObject tunnel2;
    public GameObject roadTrigger;
    public GameObject road;
    //variables for database connection
    string urlProjects = "http://mediachickens.multimediatechnology.be/unity/al_projecten/api"; //url of json to be decoded
    ObjectJSONProjects[] arrProjects;
    ObjectJSONQuestions[] arrQuestions;

    //variables for project choice
    byte currentProject = 0; //change when user choose projects is added
    public TextMesh txtProjectName;
    public TextMesh txtProjectDescription;
    public TextMesh txtProjectDates;
    //button to restart the game + background on canvas
    public Button btnRestart;
    public Image bgEndScreen;
    public RawImage logoEndScreen;
    public Text txtAnswered;
    public Button btnPause;
    public Button btnContinue;
    public Text txtPause;

    //how to text
    public TextMesh txtHowTo;
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
    public GameObject tunnel1Option4;
    public GameObject tunnel2Option4;
    public GameObject tunnel1Option2;
    public GameObject tunnel2Option2;

    //spawning roads and text object
    private float spawnDistance = 200;

    //script of player to change is running
    Player playerScript;


    void Start () {
        txtHowTo.gameObject.SetActive(false);
        StartCoroutine(getProjectsFromURL(urlProjects));
        playerScript = GetComponent<Player>();
        txtProjectName.text = "veeg naar links \n en rechts \n om een project \n te kiezen";
        btnPause.GetComponent<Button>();
        btnContinue.GetComponent<Button>();
        btnPause.onClick.AddListener(() => { BtnPauseClicked(); });
        btnContinue.onClick.AddListener(() => { BtnContinueClicked(); });
        btnRestart.gameObject.SetActive(false);
     //   bgEndScreen.gameObject.SetActive(false);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(false);
        btnContinue.gameObject.SetActive(false);
      //  txtPause.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(false);
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
        else if (other.gameObject.tag == "AnswerD")
        {
            answerCount++;
            playerAnswers.Enqueue('D');
        }
        else if (other.gameObject.tag == "NoAnswer")
        {
            answerCount++;
            playerAnswers.Enqueue('N');
        }
        if (other.gameObject.tag == "StartGame")
        {
            txtHowTo.gameObject.SetActive(false);
            if (arrQuestions.Length < 1 || arrQuestions[0] == null) //stop game if there aren't any questions
            {
                isPlaying = false;
                bgEndScreen.gameObject.SetActive(true);
                btnRestart.gameObject.SetActive(true);
                txtAnswered.gameObject.SetActive(true);
            }
            else { 
            if(arrQuestions[0].type == "Gesloten vragen")
            {
                tunnel1Option2.gameObject.SetActive(true);
                tunnel1Option4.gameObject.SetActive(false);
                    playerScript.maxLaneLeft = 2;
                    txtAnswer3.text = "";
                    txtAnswer4.text = "";
                }
                else
                {
                    txtAnswer3.text = arrQuestions[answerCount].possibility3;
                    txtAnswer4.text = arrQuestions[answerCount].possibility4;
                }
            
            if (arrQuestions.Length >= 2 && arrQuestions[1] != null) { 
            if (arrQuestions[1].type == "Gesloten vragen")
            {
                tunnel2Option2.gameObject.SetActive(true);
                tunnel2Option4.gameObject.SetActive(false);

            }
            }
            txtAnswer1.text = arrQuestions[answerCount].possibility1;
            txtAnswer2.text = arrQuestions[answerCount].possibility2;
            txtQuestion.text = arrQuestions[answerCount].question;
            txtnoAnswer.text = "geen \n mening";
            }
        }
        if (other.gameObject.CompareTag("TriggerRoadSpawn"))
        {
            Destroy(other.gameObject);
            RoadSpawn();
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
                if(arrQuestions[answerCount].type == "Gesloten vragen")
                {
                    txtAnswer3.text = "";
                    txtAnswer4.text = "";
                    playerScript.maxLaneLeft = 2;
                }
                else {
                    playerScript.maxLaneLeft = 0;
                txtAnswer3.text = arrQuestions[answerCount].possibility3;
                txtAnswer4.text = arrQuestions[answerCount].possibility4;
                }
                txtAnswer1.text = arrQuestions[answerCount].possibility1;
                txtAnswer2.text = arrQuestions[answerCount].possibility2;
                txtQuestion.text = arrQuestions[answerCount].question;
                txtOnTunnels.transform.position = new Vector3(txtOnTunnels.transform.position.x, txtOnTunnels.transform.position.y, txtOnTunnels.transform.position.z + spawnDistance);
            }
        }
    }

    void FixedUpdate() //always being called
    {
        if (!isPlaying && isChoosing) {
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
                                txtProjectDescription.text = arrProjects[currentProject].description;
                                txtProjectDates.text = arrProjects[currentProject].date;
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
                                txtProjectDescription.text = arrProjects[currentProject].description;
                                txtProjectDates.text = arrProjects[currentProject].date;
                            
                        }
                        else if (!swipedSideways && deltaYSwipe <= 0) //swiped up
                        {
                            txtHowTo.gameObject.SetActive(true);
                        isPlaying = true;
                        StartCoroutine(getQuestionsFromURL(getQuestionsUrl(arrProjects[currentProject].id.ToString()))); //getting questions once player has chosen project
                        playerScript.isRunning = true;
                        playerScript.hasSwipedUp = true;
                            btnPause.gameObject.SetActive(true);
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
    
    
    public class ObjectJSONProjects //type of objects with info for projects
    {
        //{"id":10,"titel":"W<CW<C","beschrijving":"klick op mij en pas mij aan voor de beschrijving",
        //"begin_datum":"0000-00-00","eind_datum":"0000-00-00","project_picture":"proef_proef.jpg",
        //"user_id":"1","deleted_at":null,"created_at":"2016-05-13 07:40:35","updated_at":"2016-05-13 07:40:35"}
        string jID;
        string projectTitle;
        string projectDescription;
        string projectDate;

        public ObjectJSONProjects() { } //empty for default
        public ObjectJSONProjects(string tID, string tTitle, string tDescription, string startDate, string endDate)
        {
            jID = tID;
            projectTitle = splitProjectsString(tTitle);
            projectDescription = splitProjectsString( tDescription);
            projectDate = startDate + "\n tot \n" + endDate;

        }

        public string id
        {
            get
            {
                return jID;
            }
        }
        public string date
        {
            get
            {
                return projectDate;
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
        private string splitProjectsString(string stringToSplit)
        {
            if (stringToSplit.Length > 15) // doesn't fit in screen any more
            {
                int lettersOnLine = 0;
                string stringToReturn = "";
                string[] wordsInString = stringToSplit.Split(' ');
                for (int i = 0; i < wordsInString.Length; i++)
                {
                    lettersOnLine += wordsInString[i].Length;
                    if (lettersOnLine >= 7)
                    {
                        stringToReturn += " " + wordsInString[i] + "\n";
                        lettersOnLine = 0;
                    }
                    else
                    {
                        stringToReturn += " " + wordsInString[i];
                    }
                }
                return stringToReturn;
            }
            else
            {
                return stringToSplit;
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
            qQuestion = splitQuestionStrings(tQuestion);
            possibleAnswers1 = splitQuestionStrings(tPossibleAnswers1);
            possibleAnswers2 = splitQuestionStrings(tPossibleAnswers2);
            possibleAnswers3 = splitQuestionStrings(tPossibleAnswers3);
            possibleAnswers4 = splitQuestionStrings(tPossibleAnswers4);

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
        private string splitQuestionStrings(string stringToSplit)
        {
            if (stringToSplit.Length > 15) // doesn't fit in screen any more
            {
                int lettersOnLine = 0;
                string stringToReturn = "";
                string[] wordsInString = stringToSplit.Split(' ');
                for (int i = 0; i < wordsInString.Length; i++)
                {
                   lettersOnLine += wordsInString[i].Length;
                    if(lettersOnLine >= 8)
                    {
                        stringToReturn += " " + wordsInString[i] + "\n";
                        lettersOnLine = 0;
                    }
                    else
                    {
                        stringToReturn += " " + wordsInString[i];
                    }
                }
                return stringToReturn;
            }
            else
            {
                return stringToSplit;
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
            arrProjects[i] = new ObjectJSONProjects(dataProjects[i]["id"].ToString(), dataProjects[i]["titel"].ToString(), dataProjects[i]["beschrijving"].ToString(), dataProjects[i]["begin_datum"].ToString(), dataProjects[i]["eind_datum"].ToString()); // json object oproepen door (id)
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
        txtPause.text = "Pauze";
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


    void RoadSpawn()
    {
        if(answerCount+2 < arrQuestions.Length && arrQuestions[answerCount+2] != null) { 
            if(arrQuestions[answerCount + 2].type == "Gesloten vragen") { 
        Instantiate(tunnel2, new Vector3(35.2f, 0.002f, this.transform.position.z + (spawnDistance * 3)), Quaternion.identity);
                Debug.Log("instantiate tunnel 2");
            }
            else if(arrQuestions[answerCount + 2].type == "meerkeuzevragen")
            {
                Debug.Log("instantiate tunnel 4");
                Instantiate(tunnel4, new Vector3(35.2f, 0.002f, this.transform.position.z + (spawnDistance * 3)), Quaternion.identity);
            }
                Instantiate(roadTrigger, new Vector3(35.13f, 10, this.transform.position.z + spawnDistance), Quaternion.identity);
    }
        else
        {
            Debug.Log("end game");
            Instantiate(road, new Vector3(35.2f, 0.002f, this.transform.position.z + (spawnDistance * 3)), Quaternion.identity);
        }
    }

}

