using UnityEngine;

public class CameraScript : MonoBehaviour
{
    //script turns camera and cleans the objects that are out of sight, when there are a lot of questions the scene remains proper and has little performance loss

    //variables for turning camera to projects screen
    public float startPositionCameraZ;


    void OnTriggerExit(Collider other)
    {
        if(other.gameObject.tag == "Environment")
        {
            Destroy(other.gameObject);
        }
    }
    void Start()
    {
        startPositionCameraZ = transform.position.z;
    }
    void Update()
    {
        if(transform.position.z > -70 && transform.rotation.y > 0.05)// 
        {
            transform.rotation *= Quaternion.Euler(0.1f, -0.15f, 0);
        }
    }
}
