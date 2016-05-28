using UnityEngine;

public class CameraScript : MonoBehaviour
{
    //script cleans the objects that are out of sight, when there are a lot of questions the scene remains proper and has little performance loss
    void OnTriggerExit(Collider other)
    {
        if(other.gameObject.tag == "Environment")
        {
            Destroy(other.gameObject);
        }
    }
}
