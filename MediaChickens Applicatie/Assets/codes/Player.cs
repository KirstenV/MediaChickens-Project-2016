using UnityEngine;
using UnityEngine.UI;
//JSON
using System.Collections;
using System.Collections.Generic;
using LitJson;

public class Player : MonoBehaviour {

    //variables for swipe
    private Touch initialTouchSwipe = new Touch();
    private float distanceSwipe = 0;
    private bool hasSwiped = false;
    //rigidbody for movement with force
     Rigidbody rb;

    //lane in which player is running, only 5 lanes
    private byte currentLane;
    public byte maxLaneLeft = 0;
    //force to move player
    private short forceSide = 700; //7000 //590 600acceler
    private short forceUp = 225; //7800 //290 impuls 250
    private float speed = 0.7f;
    private float speedSlow = 0.7f;
    private float speedFast = 1f;
    private float playerOnGround = 1.30f;
    //rigidbodys for turning on the townsquare
    public Rigidbody road1;
    //if player has chosen answer
    public bool hasSwipedUp = false;
    public bool isRunning = false;

    //connection with other script
    public GameObject otherScript;
    databaseConnection scriptDatabase;

    //camera for lerp
    public Camera mainCam;
    float distanceFromPlayer;



    void Start()
    {
        scriptDatabase = GetComponent<databaseConnection>();
        

        rb = GetComponent<Rigidbody>();
        rb.constraints = RigidbodyConstraints.FreezeRotation;
        currentLane = 2; //0links, 1 midden,2 rechts
        road1.constraints = RigidbodyConstraints.FreezeRotationX | RigidbodyConstraints.FreezeRotationZ | RigidbodyConstraints.FreezePosition ;
        road1.centerOfMass = new Vector3(0, 0, 0);
        //JSon 

    }
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.tag == "MoveToRight")
        {
            speed = speedSlow;
            rb.AddForce(forceSide, forceUp, 0, ForceMode.Impulse);
            currentLane++;
            hasSwipedUp = false;
        }
        if (other.gameObject.tag == "Tunnel")
        {
            if (!hasSwipedUp)
            {
                isRunning = false;
            }
        }
        if (other.gameObject.tag == "StartGame")
        {
            hasSwipedUp = false;
            speed = speedSlow;
        }
        if (other.gameObject.tag == "BuildingsTownSquare")
        {

        }
        
    }
    void OnTriggerExit(Collider other)
    {
        if (other.gameObject.tag == "Tunnel")
        {
            hasSwipedUp = false;
            speed = speedSlow;
        }
        if (other.gameObject.tag == "BuildingsTownSquare")
        {
            hasSwipedUp = false;
            speed = speedSlow;
        }
    }
    void FixedUpdate() //always being called
    {
        if (scriptDatabase.isPlaying) {
            if(this.transform.position.z-mainCam.transform.position.z < 4)
            {
                distanceFromPlayer = mainCam.transform.position.z;
            }
            else { distanceFromPlayer = this.transform.position.z; }
            mainCam.transform.position = Vector3.Lerp(mainCam.transform.position, new Vector3(this.transform.position.x, mainCam.transform.position.y, distanceFromPlayer), 5.0f * Time.deltaTime);
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
                    if (distanceSwipe > 100 && this.transform.position.y < playerOnGround)//100
                    {
                        if (swipedSideways && deltaXSwipe > 0) //swiped left
                        {
                            Debug.Log("currentlane:" + currentLane + "max lane" + maxLaneLeft);
                                if (currentLane <= maxLaneLeft) // player not on left lane
                            {
                            }
                                else if(currentLane == 4)
                            {
                                rb.AddForce(-(forceSide*1.5f), forceUp, 0, ForceMode.Impulse); //force
                                currentLane--;
                            }
                            else
                            {
                                rb.AddForce(-forceSide, forceUp, 0, ForceMode.Impulse);
                                currentLane--;
                            }
                            
                        }

                        else if (swipedSideways && deltaXSwipe <= 0) //swiped right
                        {
                                if (currentLane == 4)// player not on right lane
                                {
                                //do nothing
                                }
                                else if(currentLane == 3)
                               {
                                rb.AddForce(forceSide * 1.5f, forceUp, 0, ForceMode.Impulse);
                                currentLane++;
                            }
                               else
                               {
                                rb.AddForce(forceSide, forceUp, 0, ForceMode.Impulse);
                                currentLane++;
                                }
                           
                        }
                        else if (!swipedSideways && deltaYSwipe <= 0) //swiped up
                        {
                            isRunning = true;
                            hasSwipedUp = true;
                            speed = speedFast;
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

    
        
   
   