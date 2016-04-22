using UnityEngine;
using UnityEngine.UI;
//JSON
using System.Collections;


public class Player : MonoBehaviour {
    //variables for swipe
    private Touch initialTouchSwipe = new Touch();
    private float distanceSwipe = 0;
    private bool hasSwiped = false;
    private bool alive = true;
    //rigidbody for movement with force
    public Rigidbody rb;
    //score + label
    private float score;
    public Text scoreText;
    //Speed + level up
    private float speed = 0.3f;
    private float levelUpTimer = 0; 
    //lane in which player is running, only 3 lanes
    private byte currentLane;
    //height from which player can jump again
    private float playerOnGroundJump = 1.2f;
    //force to move player
    private float forceSide = 7000;
    private float forceUp = 7500;
    private float forceJump = 14000; 

    



    void Start()
    {
        rb = GetComponent<Rigidbody>();
        score = 0;
        currentLane = 1; //0 links, 1 midden,2 rechts
        
    }
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.CompareTag("Enemy"))
        {
         //   alive = false;

        }
    }
    void FixedUpdate() //always being called
    {
        
       
        if (alive)
        {
            
            score = Mathf.Round(Time.fixedTime * 100);
            scoreText.text = score.ToString();
            if ((score - levelUpTimer) >= 1000) //if the difference between the current score (= time) and the leveluptimer is bigger then 1000, he levels up 
            {
                levelUpTimer = score;
                speed += 0.06f;
            }



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
    }


    } 

    
        
   
   