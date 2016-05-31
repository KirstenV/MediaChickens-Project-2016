using UnityEngine;

public class Player : MonoBehaviour {
    //connection with other scripts
    databaseConnection scriptDatabase;

    //rigidbody for movement with force
    private Rigidbody rb;

    //animator for character
    private Animator characterAnimator;

    //lane in which player is running, only 5 lanes
    public byte currentLane = 2;
    public byte maxLaneLeft = 0; //lane left can be changed when less possible answers
    public byte maxLaneRight = 4;
    public byte maxLaneActualAnswers = 3;

    //force and speed to move player
    public short forceSide = 700;
    public short forceUp = 225; 
    private float speed = 0.7f;
    public float speedSlow = 0.7f;
    public float speedFast = 1f;
    public float playerOnGround = 1.30f;

    //if player has chosen answer or jumped
    public bool hasSwipedUp = false;

   // public bool isRunning = false;

    //camera for lerp
    public Camera mainCam;
    private float distanceFromPlayer;
    public byte minimumDistanceFromPlayer = 4;
    public float cameraFollowSpeed = 5.0f;

    void Start()
    {
        scriptDatabase = GetComponent<databaseConnection>();
        rb = GetComponent<Rigidbody>();
        rb.constraints = RigidbodyConstraints.FreezeRotation; 
        characterAnimator = this.GetComponent<Animator>();
     }
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.tag == "MoveToRight") //when only 2 possible answers, player is forced to move to right
        {
            characterAnimator.SetBool("jumpedRight", true);
            speed = speedSlow; //player is slowed down
            rb.AddForce(forceSide, forceUp, 0, ForceMode.Impulse);
            currentLane++;
            hasSwipedUp = false;
        }
        if (other.gameObject.tag == "Tunnel") //if user reached tunnel, and hasn't swiped up, character stops running
        {
            if (!hasSwipedUp)
            {
               characterAnimator.SetBool("isRunning",false);
            }
        }
        if (other.gameObject.tag == "StartGame") 
        {
            hasSwipedUp = false;
            speed = speedSlow;
        }
    }
    void OnTriggerExit(Collider other)
    {
        if (other.gameObject.tag == "Tunnel")
        {
            hasSwipedUp = false;
            speed = speedSlow;
            characterAnimator.SetBool("isRunning", true);

        }
        if (other.gameObject.tag == "BuildingsTownSquare")
        {
            hasSwipedUp = false;
            speed = speedSlow;
        }
    }
    void FixedUpdate() //always being called
    {
        if (characterAnimator.GetBool("jumpedLeft") || characterAnimator.GetBool("jumpedRight"))
        {
            characterAnimator.SetBool("jumpedLeft", false);
            characterAnimator.SetBool("jumpedRight", false);
        }


        if (this.transform.position.z - mainCam.transform.position.z < minimumDistanceFromPlayer) //if the player stops running, camera stops as well
        {
            distanceFromPlayer = mainCam.transform.position.z;
        }
        else { distanceFromPlayer = this.transform.position.z; } //else camera follows player
        mainCam.transform.position = Vector3.Lerp(mainCam.transform.position, new Vector3(this.transform.position.x, mainCam.transform.position.y, distanceFromPlayer), cameraFollowSpeed * Time.deltaTime);


        if (characterAnimator.GetBool("isRunning"))
        { //when player is choosing answers
            this.transform.position = this.transform.position + new Vector3(0, 0, speed);
        }
    }

    
    public void swipedLeft()
    {
    if (currentLane <= maxLaneLeft) // if player is on left lane, do nothing
    {
    }
    else if (currentLane == maxLaneRight)
    {
        characterAnimator.SetBool("jumpedLeft", true);
        rb.AddForce(-(forceSide + (forceSide / 2)), forceUp, 0, ForceMode.Impulse); //when player is on no-answer lane
        currentLane--;

    }
    else
    {
        characterAnimator.SetBool("jumpedLeft", true);
        rb.AddForce(-forceSide, forceUp, 0, ForceMode.Impulse); //when player is on normal lanes
        currentLane--;

    }
}
    public void swipedRight()
    {
        if (currentLane == maxLaneRight)// player is on right lane
        {
            //do nothing
        }
        else if (currentLane == maxLaneActualAnswers) //player is going to no answer lane, needs more force
        {
            characterAnimator.SetBool("jumpedRight", true);
            rb.AddForce(forceSide + (forceSide / 2), forceUp, 0, ForceMode.Impulse);
            currentLane++;
        }
        else //player is on middle answer lanes
        {
            characterAnimator.SetBool("jumpedRight", true);
            rb.AddForce(forceSide, forceUp, 0, ForceMode.Impulse);
            currentLane++;
        }
    }
    public void swipedUp()
    {
        characterAnimator.SetBool("isRunning", true);
        hasSwipedUp = true;
        speed = speedFast;
    }

} 

    
        
   
   