using UnityEngine;
using UnityEngine.UI;
//JSON
using System.Collections;
using System.Collections.Generic;
using LitJson;

public class Player : MonoBehaviour {
    //variables for middle of roads
   /* private float leftRoad = 28;
    private float middleRoad = 36;
    private float rightRoad = 44;*/


    //variables for swipe
    private Touch initialTouchSwipe = new Touch();
    private float distanceSwipe = 0;
    private bool hasSwiped = false;
    //rigidbody for movement with force
    public Rigidbody rb;
    //lane in which player is running, only 3 lanes
    private byte currentLane;
    //height from which player can jump again
    private float playerOnGroundJump = 0.1f;
    //force to move player
    private short forceSide = 7000;
    private short forceUp = 7800;
    private float speed = 0.35f;
    //if the player has chosen the project and is 'playing the game'
    private bool isPlaying = false;
    //rigidbodys for turning on the townsquare
    public Rigidbody road1;
    //if player has chosen answer
    bool hasSwipedUp = false;
    bool isRunning = false;
    //list of answers
    Queue<char> playerAnswers = new Queue<char>();
    byte maxAnswers = 5;

    //button to restart the game + background on canvas
    public Button btnRestart;
    public Image bgEndScreen;
    public RawImage logoEndScreen;
    public Text txtAnswered;
    public Button btnPause;
    public Button btnContinue;
    public Text txtPause;

    //variables for database connection
    string url = "http://mediachickens.multimediatechnology.be/unity/al_projecten/api"; //url of json to be decoded
    string questionsUrl; //145 vervangen door id project


    IEnumerator Start() //IEnumerator for json
    {

        rb = GetComponent<Rigidbody>();
        btnPause.GetComponent<Button>();
        btnContinue.GetComponent<Button>();
        btnPause.onClick.AddListener(() => { BtnPauseClicked();});
        btnContinue.onClick.AddListener(() => { BtnContinueClicked(); });
        rb.constraints = RigidbodyConstraints.FreezeRotation;
        btnRestart.gameObject.SetActive(false);
        bgEndScreen.gameObject.SetActive(false);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(false);
        btnContinue.gameObject.SetActive(false);
        txtPause.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(true);
        currentLane = 1; //0links, 1 midden,2 rechts
        road1.constraints = RigidbodyConstraints.FreezeRotationX | RigidbodyConstraints.FreezeRotationZ | RigidbodyConstraints.FreezePosition ;
        road1.centerOfMass = new Vector3(0, 0, 0);
        //JSon 
        WWW wwwQuestions = new WWW(getQuestions("10")); //nr checken!!!
        WWW wwwProjects = new WWW(url);

        yield return wwwProjects;
        yield return wwwQuestions;
        if (wwwProjects.error == null)
        {
            objectJSON[] arrProjects = getProjects(wwwProjects.text);
        }
        else
        {
            Debug.Log("ERROR: " + wwwProjects.error);
        }
        

    }
    void OnTriggerEnter(Collider other)
    {
        
        if (other.gameObject.tag == "AnswerA")
        {
            playerAnswers.Enqueue('A');
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            playerAnswers.Enqueue('B');
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            playerAnswers.Enqueue('C');
        }
        if(other.gameObject.tag == "Tunnel")
        {
            if (!hasSwipedUp)
            {
                isRunning = false;
            }
        }
        
    }
    void OnTriggerExit(Collider other)
    {
        if(other.gameObject.tag == "Tunnel")
        {
            hasSwipedUp = false;
            speed = 0.35f;
            if(playerAnswers.Count == maxAnswers)
            {
                isPlaying = false;
                isRunning = false;
                bgEndScreen.gameObject.SetActive(true);
                btnRestart.gameObject.SetActive(true);
                txtAnswered.gameObject.SetActive(true);
                logoEndScreen.gameObject.SetActive(true);
            }
        }
    }
    void FixedUpdate() //always being called
    {

            if (isRunning) { 
                this.transform.position = this.transform.position + new Vector3(0, 0, speed);
            }
            foreach (Touch t in Input.touches)
            {
                if (t.phase == TouchPhase.Began)
                {
                    initialTouchSwipe = t;
                }
                else if (t.phase == TouchPhase.Moved && !hasSwiped && !hasSwipedUp)
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
                            if (isPlaying) { 
                            if(currentLane != 0  && this.transform.position.y <= playerOnGroundJump) // player not on left lane and on ground
                                { 
                            Physics.gravity = new Vector3(0, -30F, 0);
                            rb.AddForce(-forceSide, forceUp, 0, ForceMode.Force);
                            currentLane--;
                            }
                            }
                            else// choosing project
                            {
                                road1.AddTorque(new Vector3(0, -20, 0));
                            } 
                        }
                        else if (swipedSideways && deltaXSwipe <= 0) //swiped right
                        {
                            if (isPlaying)
                            {
                                if (currentLane != 2 && this.transform.position.y <= playerOnGroundJump) { // player not on right lane and on ground
                                
                                    //   this.transform.Rotate(new Vector3(0, 15f, 0));
                                    // this.transform.position = this.transform.position + new Vector3(15f, 0, 0);
                                    Physics.gravity = new Vector3(0, -30F, 0);
                            rb.AddForce(forceSide, forceUp, 0, ForceMode.Force);
                                currentLane++;
                            }
                            }
                            else//choosing project
                            {
                                road1.AddTorque(new Vector3(0, 20, 0));
                            
                            }
                        }
                        else if (!swipedSideways && deltaYSwipe <= 0 && this.transform.position.y <= playerOnGroundJump) //swiped up
                        {
                            if (isPlaying ) { 
                            isRunning = true;
                            hasSwipedUp = true;
                            speed = 0.7f;
                            }
                            else
                            {
                                isPlaying = true;
                                isRunning = true;
                            }
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
    void BtnPauseClicked()
    {
        isPlaying = false;
        isRunning = false;
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
        isRunning = true;
        bgEndScreen.gameObject.SetActive(false);
        btnRestart.gameObject.SetActive(false);
        txtAnswered.gameObject.SetActive(false);
        logoEndScreen.gameObject.SetActive(false);
        btnPause.gameObject.SetActive(true);
        btnContinue.gameObject.SetActive(false);
        txtPause.gameObject.SetActive(false);
    }

    public class objectJSON
    {
        string jID;
        public objectJSON() { }
        public objectJSON(string tID)
        {
            jID = tID;
        }
        
        public string id
        {
            get
            {
                return jID;
            }
        }
    }

    private objectJSON[] getProjects(string jsonString) // jsonstring
    {
        
       JsonData jsonvale = JsonMapper.ToObject(jsonString);
        objectJSON[] arrProjectsTemp = new objectJSON[jsonvale.Count];
        for (int i = 0; i < jsonvale.Count; i++)
        {
            
            arrProjectsTemp[i] = new objectJSON(jsonvale[i]["id"].ToString()); // json object oproepen door (id)
            Debug.Log(arrProjectsTemp[i].id);
        }
        return arrProjectsTemp;
       /* parseJSON parsejson;
        parsejson = new parseJSON();
      //  parsejson.title = jsonvale["title"].ToString();
        parsejson.id = jsonvale["id"].ToString();
       */
       
    }
    private string getQuestions(string projectID)
    {
        
       string urlPart1 = "http://mediachickens.multimediatechnology.be/unity/vragen/";
        string urlPart2 = "/api";
       return urlPart1 + projectID + urlPart2;


    }
    IEnumerator getJSONFromURL()
    {

    }


} 

    
        
   
   