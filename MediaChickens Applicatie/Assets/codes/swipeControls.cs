using UnityEngine;
using System.Collections;

public class swipeControls : MonoBehaviour {
    //variables used for swipe touch registration
    private Touch initialTouchSwipe = new Touch();
    private float distanceSwipe = 0;
    private bool hasSwiped = false;
    private byte distanceToRegisterSwipe = 100;
    public bool gamePaused = false;
    public bool choosingProject = true;

    //other scripts for calling swipe methods
    private Player playerScript;
    private databaseConnection databaseScript;
    private Animator characterAnimator;
   
    // Use this for initialization
    void Start () {
        playerScript = GetComponent<Player>();
        databaseScript = GetComponent<databaseConnection>();
        characterAnimator = GetComponent<Animator>();
    }
    void FixedUpdate() //always being called
    {
        if (!gamePaused) {
            foreach (Touch t in Input.touches)
            {
                if (t.phase == TouchPhase.Began)
                {
                    initialTouchSwipe = t;
                }
                else if (t.phase == TouchPhase.Moved && !hasSwiped)
                {
                    //Swipedistance formula
                    float deltaXSwipe = initialTouchSwipe.position.x - t.position.x;
                    float deltaYSwipe = initialTouchSwipe.position.y - t.position.y;
                    distanceSwipe = Mathf.Sqrt((deltaXSwipe* deltaXSwipe) + (deltaYSwipe* deltaYSwipe));

                    //Swipedirection formula
                    bool swipedSideways = Mathf.Abs(deltaXSwipe) > Mathf.Abs(deltaYSwipe); //swipe up and down or sideways
                    if (distanceSwipe > distanceToRegisterSwipe)
                    {
                        if (swipedSideways && deltaXSwipe > 0) //swiped left
                        {
                            if (choosingProject)
                            {
                                databaseScript.swipedLeft();
                            }
                            else
                            {
                                playerScript.swipedLeft();
                            }
                        }
                        else if (swipedSideways && deltaXSwipe <= 0) //swiped right, change project
                        {
                            if (choosingProject)
                            {
                                databaseScript.swipedRight();
                            }
                            else
                            {
                                playerScript.swipedRight();
                            }
                        }
                        else if (!swipedSideways && deltaYSwipe <= 0) //swiped up, start game/answering questions
                        {
                            if (choosingProject)
                            {
                                choosingProject = false;
                                databaseScript.swipedUp();
                            }
                            else
                            {
                                playerScript.swipedUp();
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

    }

}
