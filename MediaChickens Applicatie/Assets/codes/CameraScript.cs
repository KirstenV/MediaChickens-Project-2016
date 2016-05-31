using UnityEngine;

public class CameraScript : MonoBehaviour
{
    //script turns camera and cleans the objects that are out of sight, when there are a lot of questions the scene remains proper and has little performance loss

    //variables for turning camera to projects screen
    public float startPositionCameraZ;
    public float positionCameraTurnStart = -70;
    public float rotationCameraStop = 0.05f;
    public float speedRotationX = 0.1f;
    public float speedRotationY = -0.15f;

    void OnTriggerExit(Collider other)
    {
        if(other.gameObject.tag == "Environment") //delete the gameobjects out of sight
        {
            Destroy(other.gameObject);
        }
    }
    void Start()
    {
        startPositionCameraZ = transform.position.z; //fills in the start position from the camera
    }
    void Update()
    {
        if(transform.position.z > positionCameraTurnStart && transform.rotation.y > rotationCameraStop)//position to start turning camera, ratation to stop camera from turning when right angle reached
        {
            transform.rotation *= Quaternion.Euler(speedRotationX, speedRotationY, 0); //rotates camera
        }
    }
}
