using UnityEngine;
using UnityEngine.UI;
//JSON
using System.Collections;


public class Player : MonoBehaviour {
    //variables for middle of roads
    private float leftRoad = 28;
    private float middleRoad = 36;
    private float rightRoad = 44;


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
    private float forceSide = 7000;
    private float forceUp = 7800;
    private float forceJump = 14000;
    private float speed = 0.35f;
    //if the player has chosen the project and is 'playing the game'
    private bool isPlaying = false;
    //rigidbodys for turning on the townsquare
    public Rigidbody road1;



    //button to restart the game --> only for demo
    public Button btnRestart;




    void Start()
    {
        rb = GetComponent<Rigidbody>();
        rb.constraints = RigidbodyConstraints.FreezeRotation;
        btnRestart.gameObject.SetActive(false);
        currentLane = 1; //0links, 1 midden,2 rechts
        road1.constraints = RigidbodyConstraints.FreezeRotationX | RigidbodyConstraints.FreezeRotationZ | RigidbodyConstraints.FreezePosition ;
        road1.centerOfMass = new Vector3(0, 0, 0);
}
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.tag == "AnswerA")
        {
            Debug.Log("answered A");
        }
        else if (other.gameObject.tag == "AnswerB")
        {
            Debug.Log("answered B");
        }
        else if (other.gameObject.tag == "AnswerC")
        {
            Debug.Log("answered C");
        }
    }
    void FixedUpdate() //always being called
    {
        if (isPlaying) { 
            this.transform.position = this.transform.position + new Vector3(0, 0, speed);
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
                            if(currentLane != 0  && this.transform.position.y <= playerOnGroundJump) { 
                            //this.transform.position = this.transform.position + new Vector3(-15f, 0, 0);
                            Physics.gravity = new Vector3(0, -30F, 0);
                            rb.AddForce(-forceSide, forceUp, 0, ForceMode.Force);
                            currentLane--;
                            }
                        }
                        else if (swipedSideways && deltaXSwipe <= 0) //swiped right
                        {
                            if(currentLane != 2 && this.transform.position.y <= playerOnGroundJump) { 
                            //   this.transform.Rotate(new Vector3(0, 15f, 0));
                            // this.transform.position = this.transform.position + new Vector3(15f, 0, 0);
                            Physics.gravity = new Vector3(0, -30F, 0);
                            rb.AddForce(forceSide, forceUp, 0, ForceMode.Force);
                                currentLane++;
                            }
                        }
                        else if (!swipedSideways && deltaYSwipe > 0) //swiped down
                        {
                           

                        }
                        else if (!swipedSideways && deltaYSwipe <= 0 && this.transform.position.y <= playerOnGroundJump) //swiped up
                        {
                            Physics.gravity = new Vector3(0, -50F, 0);
                            rb.AddForce(0, forceJump, 0, ForceMode.Force); 
                            
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
        else
        {
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
                            Debug.Log("swiped Left");
                            road1.AddTorque(new Vector3(0, -20, 0));
                        }
                        else if (swipedSideways && deltaXSwipe <= 0) //swiped right
                        {
                            Debug.Log("swiped Right");
                            road1.AddTorque(new Vector3(0, 20, 0));
                        }
                        else if (!swipedSideways && deltaYSwipe > 0) //swiped down
                        {


                        }
                        else if (!swipedSideways && deltaYSwipe <= 0 && this.transform.position.y <= playerOnGroundJump) //swiped up
                        {
                            isPlaying = true;

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
    
    } 

    
        
   
   