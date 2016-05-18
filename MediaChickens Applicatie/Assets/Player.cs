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
     Rigidbody rb;
    //lane in which player is running, only 3 lanes
    private byte currentLane;
    //force to move player
    private short forceSide = 7000;
    private short forceUp = 7800;
    private float speed = 0.35f;
    //rigidbodys for turning on the townsquare
    public Rigidbody road1;
    //if player has chosen answer
    public bool hasSwipedUp = false;
    public bool isRunning = false;

    //connection with other script
    public GameObject otherScript;
    databaseConnection scriptDatabase;

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
       
        if(other.gameObject.tag == "Tunnel")
        {
            if (!hasSwipedUp)
            {
                isRunning = false;
            }
        }
        if(other.gameObject.tag == "StartGame")
        {
            hasSwipedUp = false;
        }
        
    }
    void OnTriggerExit(Collider other)
    {
        if (other.gameObject.tag == "Tunnel")
        {
            hasSwipedUp = false;
            speed = 0.35f;
        }
        if (other.gameObject.tag == "BuildingsTownSquare")
        {
            hasSwipedUp = false;
            speed = 0.35f;
        }
    }
    void FixedUpdate() //always being called
    {
        if (scriptDatabase.isPlaying) {
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
                                if (currentLane == 0) // player not on left lane
                            {
                            }
                                else if(currentLane == 4)
                            {
                                Physics.gravity = new Vector3(0, -30F, 0);
                                rb.AddForce(-(forceSide*1.5f), forceUp, 0, ForceMode.Force);
                                currentLane--;
                            }
                            else
                            {
                                Physics.gravity = new Vector3(0, -30F, 0);
                                rb.AddForce(-forceSide, forceUp, 0, ForceMode.Force);
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
                                Physics.gravity = new Vector3(0, -30F, 0);
                                rb.AddForce(forceSide * 1.5f, forceUp, 0, ForceMode.Force);
                                currentLane++;
                            }
                               else
                               {
                                Physics.gravity = new Vector3(0, -30F, 0);
                                rb.AddForce(forceSide, forceUp, 0, ForceMode.Force);
                                currentLane++;
                                }
                           
                        }
                        else if (!swipedSideways && deltaYSwipe <= 0) //swiped up
                        {
                            isRunning = true;
                            hasSwipedUp = true;
                            speed = 0.7f;
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

    
        
   
   