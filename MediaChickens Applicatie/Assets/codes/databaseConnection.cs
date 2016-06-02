using UnityEngine;
using System.Collections;
using LitJson;

public class databaseConnection : MonoBehaviour {
    //script of Player and canvas
    Player playerScript;
    canvasScript scriptCanvas;

    //game is not paused
    public bool isPlaying = false;

    //animator for character
    private Animator characterAnimator;

    //roadSpawn
    public GameObject tunnel4;
    public GameObject tunnel2;
    public GameObject roadTrigger;
    public GameObject road;
    public float roadYPosition = 0.002f;
    public float roadXPosition = 35.2f;
    public float tunnelYPosition = 0.002f;
    public float tunnelXposition = 35.2f;
    public float triggerYPosition = 10;
    public float triggerXPosition = 35.13f; 
    private byte numberFirstTunnelSpawn = 3;

    //variables for database connection
    private string urlProjects = "http://mediachickens.multimediatechnology.be/unity/al_projecten/api"; //url of json to be decoded
    private ObjectJSONProjects[] arrProjects;
    public ObjectJSONQuestions[] arrQuestions;

    //variables for project choice
    private byte currentProject = 0; //change when user choose projects is added
    public TextMesh txtProjectName;
    public TextMesh txtProjectDescription;
    public TextMesh txtProjectDates;

    //show possible answers, counts number of answers already given
    private byte answerCount = 0;

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
   public float spawnDistance = 243.68f;

    //maximum lane player can run on (to be send to player)
    private byte maxLaneLeftClosedQuestion = 2;

    //project object variables
    public byte lengthStringSplitProject = 15;
    public byte maxLettersOnLineProject = 50;
    public byte maxEntersProject = 20;
    //question object variables
    public byte lengthStringSplitQuestions = 15;
    public byte maxLettersOnLineQuestions = 8;

    void Start () {
        StartCoroutine(getProjectsFromURL(urlProjects)); //Get projects from URL
        txtProjectName.text = " veeg naar links \n en rechts \n om project \n te zien";
        txtProjectDescription.text = " veeg omhoog om \n project te kiezen \n \n veeg hierna links \n en rechts  om het \n juiste antwoord \n te selecteren \n en veeg omhoog \n om je antwoord \n te bevestigen";
        characterAnimator = this.GetComponent<Animator>();
        playerScript = GetComponent<Player>();
        scriptCanvas = GetComponent<canvasScript>();
    }
    void OnTriggerEnter(Collider other)
    {
        //if player has chosen answer 
        if (other.gameObject.tag == "AnswerA")
        {
            answerCount++;
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            answerCount++;
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            answerCount++;
        }
        else if (other.gameObject.tag == "AnswerD")
        {
            answerCount++;
        }
        else if (other.gameObject.tag == "NoAnswer")
        {
            answerCount++;
        }

        if (other.gameObject.tag == "StartGame")
        {
            if (arrQuestions.Length < 1 || arrQuestions[0] == null) //stop game if there aren't any questions
            {
                isPlaying = false;
                scriptCanvas.showEndScreen();
            }
            else { 
            if(arrQuestions[0].type == "Gesloten vragen") //only 2 possible answers for first tunnel
            {
                tunnel1Option2.gameObject.SetActive(true);
                tunnel1Option4.gameObject.SetActive(false);
                    playerScript.maxLaneLeft = maxLaneLeftClosedQuestion;
                    txtAnswer3.text = "";
                    txtAnswer4.text = "";
                }
                else //4 possible answers for first tunnel
                {
                    txtAnswer3.text = arrQuestions[answerCount].possibility3;
                    txtAnswer4.text = arrQuestions[answerCount].possibility4;
                }
            
            if (arrQuestions.Length >= 2 && arrQuestions[1] != null) { //if there are enough questions for at least 2 tunnels
            if (arrQuestions[1].type == "Gesloten vragen") //if there are only 2 possible answers for 2nd tunnel
            {
                tunnel2Option2.gameObject.SetActive(true);
                tunnel2Option4.gameObject.SetActive(false);
            }
            }
            //change text objects to possible answers for first tunnel
            txtAnswer1.text = arrQuestions[answerCount].possibility1;
            txtAnswer2.text = arrQuestions[answerCount].possibility2;
            txtQuestion.text = arrQuestions[answerCount].question;
            txtnoAnswer.text = "geen \n mening";
            }
        }

        if (other.gameObject.CompareTag("TriggerRoadSpawn")) //spawn the road and destroy trigger
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
                scriptCanvas.showEndScreen();
            }
            else //show next tunnel question and possible answers
            {
                if(arrQuestions[answerCount].type == "Gesloten vragen") //2 possible answers
                {
                    txtAnswer3.text = "";
                    txtAnswer4.text = "";
                    playerScript.maxLaneLeft = maxLaneLeftClosedQuestion;
                }
                else { //4 possible answers
                playerScript.maxLaneLeft = 0; //reset maximum lane left
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

    public void swipedLeft()
{
        if(txtProjectDates.text == "")
        {
            txtProjectName.characterSize = txtProjectName.characterSize / 1.5f;
            txtProjectDates.characterSize = txtProjectDates.characterSize / 1.5f;
            txtProjectDescription.characterSize = txtProjectDescription.characterSize / 1.5f;
            Debug.Log("firstScreen");
        }
    if (currentProject == 0) //go to end of project line
    {
        currentProject = (byte)(arrProjects.Length - 1);
            Debug.Log(currentProject);
    }
    else
    {
        currentProject--;
    }

    txtProjectName.text = arrProjects[currentProject].title;
    txtProjectDescription.text = arrProjects[currentProject].description;
    txtProjectDates.text = arrProjects[currentProject].date;

}
    public void swipedRight()
    {
        if (txtProjectDates.text == "")
        {
            txtProjectName.characterSize = txtProjectName.characterSize / 1.5f;
            txtProjectDates.characterSize = txtProjectDates.characterSize / 1.5f;
            txtProjectDescription.characterSize = txtProjectDescription.characterSize / 1.5f;
            Debug.Log("firstScreen");
        }
        if (currentProject == (byte)(arrProjects.Length - 1)) //go to begin of project line
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
    public void swipedUp()
    {
    isPlaying = true;
    StartCoroutine(getQuestionsFromURL(getQuestionsUrl(arrProjects[currentProject].id.ToString()))); //getting questions once player has chosen project
    playerScript.hasSwipedUp = true;
    characterAnimator.SetBool("isRunning", true);
}

    public void BtnPauseClicked() //the pause button is clicked
    {
        scriptCanvas.showPauseScreen(isPlaying);
        if (isPlaying)
        {
            isPlaying = false;
        }
    }

    public void BtnContinueClicked() //continue button is clicked, game continues
    {
        isPlaying = true;
        scriptCanvas.hideAllPaused();
    }

    public class ObjectJSONProjects //objects with info for projects
    {
        string jID;
        string projectTitle;
        string projectDescription;
        string projectDate;
        byte maxLettersOnLine;
        byte lengthStringSplit;
        byte maxEnters;
        public ObjectJSONProjects() { } //empty for default
        public ObjectJSONProjects(string tID, string tTitle, string tDescription, string startDate, string endDate, byte tLengthStringSplit, byte tMaxLettersOnLine, byte tMaxEnters)
        {
            maxEnters = tMaxEnters;
            maxLettersOnLine = tMaxLettersOnLine;
            lengthStringSplit = tLengthStringSplit;
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
        private string splitProjectsString(string stringToSplit) //split string to fit on screen
        {
            if (stringToSplit.Length > lengthStringSplit) // doesn't fit in screen any more
            {
                byte entersCount = 0;
                int lettersOnLine = 0;
                string stringToReturn = "";
                string[] wordsInString = stringToSplit.Split(' ');
                for (int i = 0; i < wordsInString.Length; i++) //adds words to a new line in the string
                {
                    lettersOnLine += wordsInString[i].Length;
                    if (lettersOnLine >= maxLettersOnLine) // if the letters already added on a line are over the max, add an enter
                    {
                        if(entersCount < maxEnters)
                        { 
                        entersCount ++;
                        Debug.Log("enter");
                        stringToReturn += " " + wordsInString[i] + "\n";
                        lettersOnLine = 0;
                        }
                        else
                        {
                            stringToReturn += "\n ... meer info op website";
                            return stringToReturn;
                        }
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
        string answerToReturn1, answerToReturn2, answerToReturn3, answerToReturn4;
        byte maxLettersOnLine;
        byte lengthStringSplit;
        public ObjectJSONQuestions() { } //empty for default
        public ObjectJSONQuestions(string tID, string tType, string tQuestion, string tPossibleAnswers1, string tPossibleAnswers2, string tPossibleAnswers3, string tPossibleAnswers4, byte tLengthStringSplit, byte tMaxLettersOnLine)
        {
            maxLettersOnLine = tMaxLettersOnLine;
            lengthStringSplit = tLengthStringSplit;
            qID = tID;
            typeOfQuestion = tType;
            qQuestion = splitQuestionStrings(tQuestion);
            if(tType == "Gesloten vragen")
            {
                qQuestion = splitQuestionStringTabs(tQuestion);
            }
            possibleAnswers1 = splitQuestionStrings(tPossibleAnswers1);
            possibleAnswers2 = splitQuestionStrings(tPossibleAnswers2);
            possibleAnswers3 = splitQuestionStrings(tPossibleAnswers3);
            possibleAnswers4 = splitQuestionStrings(tPossibleAnswers4);
            answerToReturn1 = tPossibleAnswers1;
            answerToReturn2 = tPossibleAnswers2;
            answerToReturn3 = tPossibleAnswers3;
            answerToReturn4 = tPossibleAnswers4;

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
        public string stringAnswer1
        {
            get
            {
                return answerToReturn1;
            }
        }
        public string stringAnswer2
        {
            get
            {
                return answerToReturn2;
            }
        }
        public string stringAnswer3
        {
            get
            {
                return answerToReturn3;
            }
        }
        public string stringAnswer4
        {
            get
            {
                return answerToReturn4;
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
            if (stringToSplit.Length > lengthStringSplit) // doesn't fit in screen any more
            {
                int lettersOnLine = 0;
                string stringToReturn = "";
                string[] wordsInString = stringToSplit.Split(' ');
                for (int i = 0; i < wordsInString.Length; i++)
                {
                   lettersOnLine += wordsInString[i].Length;
                    if(lettersOnLine >= maxLettersOnLine)
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
    

    private string splitQuestionStringTabs(string stringToSplit)
    {
        if (stringToSplit.Length > lengthStringSplit) // doesn't fit in screen any more
        {
            int lettersOnLine = 0;
            string stringToReturn = "";
            string[] wordsInString = stringToSplit.Split(' ');
            stringToReturn += "\t \t";
            for (int i = 0; i < wordsInString.Length; i++)
            {
                lettersOnLine += wordsInString[i].Length;
                if (lettersOnLine >= maxLettersOnLine)
                {
                    stringToReturn += " " + wordsInString[i] + "\n" + "\t \t";
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
    private string getQuestionsUrl(string projectID) //makes an url from chosen project
    {
        string urlPart1 = "http://mediachickens.multimediatechnology.be/unity/vragen/";
        string urlPart2 = "/api";
        return urlPart1 + projectID + urlPart2; 
        
    } //makes the url for getting the questions from the chosen project

    IEnumerator getProjectsFromURL(string projectUrl) //getting projects from the project URL
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

    IEnumerator getQuestionsFromURL(string urlQuestions) //getting questions from the question URL
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

    private void addProjectsToArray(string jsonString) // add all projects to the projectArray
    {
        
        JsonData dataProjects = JsonMapper.ToObject(jsonString);
        arrProjects = new ObjectJSONProjects[dataProjects.Count];
        for (int i = 0; i < dataProjects.Count; i++)
        {
            arrProjects[i] = new ObjectJSONProjects(dataProjects[i]["id"].ToString(), dataProjects[i]["titel"].ToString(), dataProjects[i]["beschrijving"].ToString(), dataProjects[i]["begin_datum"].ToString(), dataProjects[i]["eind_datum"].ToString(), lengthStringSplitProject, maxLettersOnLineProject, maxEntersProject); // json object oproepen door (id)
        }
    }

    private void addQuestionsToArray(string jsonString) // adding the chosen questions to an array, ready for showing on tunnels
    {
        JsonData dateQuestion = JsonMapper.ToObject(jsonString);
        arrQuestions = new ObjectJSONQuestions[dateQuestion.Count];
        for (int i = 0, j = 0; i < dateQuestion.Count; i++, j++) //add all questions to array
        {
            if (dateQuestion[i]["choices"].ToString() != "open vragen") //if question has possible answers, add new question to array
            {
                arrQuestions[j] = new ObjectJSONQuestions(
                        dateQuestion[i]["id"].ToString(), //string tID
                        
                        dateQuestion[i]["choices"].ToString(), //Type
                        dateQuestion[i]["vraag"].ToString(), //question
                        dateQuestion[i]["mogelijke_antwoorden_1"].ToString(), //possibility1
                        dateQuestion[i]["mogelijke_antwoorden_2"].ToString(), //possibility2
                        dateQuestion[i]["mogelijke_antwoorden_3"].ToString(), //possibility3
                        dateQuestion[i]["mogelijke_antwoorden_4"].ToString(), //possibility4
                        lengthStringSplitQuestions,
                        maxLettersOnLineQuestions
                        );
            }
            else
            {
                j--;
            }
            
        }
    }


    void RoadSpawn() //automatically spawns the road when reached roadtrigger
    {
        if(answerCount+2 < arrQuestions.Length && arrQuestions[answerCount+2] != null) { //if there are questions left, show tunnel and new trigger
            if(arrQuestions[answerCount + (numberFirstTunnelSpawn-1)].type == "Gesloten vragen") { //2 possible answers
        Instantiate(tunnel2, new Vector3(tunnelXposition, tunnelYPosition, this.transform.position.z + (spawnDistance * numberFirstTunnelSpawn)), Quaternion.identity);
                }

            else if(arrQuestions[answerCount + (numberFirstTunnelSpawn-1)].type == "meerkeuzevragen") //4 possible answers
                {
                Instantiate(tunnel4, new Vector3(tunnelXposition, tunnelYPosition, this.transform.position.z + (spawnDistance * 3)), Quaternion.identity);
                 }

            Instantiate(roadTrigger, new Vector3(triggerXPosition, triggerYPosition, this.transform.position.z + spawnDistance), Quaternion.identity);
          }
        else //if no more questions show only road
        {
            Instantiate(road, new Vector3(roadXPosition, roadYPosition, this.transform.position.z + (spawnDistance * numberFirstTunnelSpawn)), Quaternion.identity);
        }
    }

}

