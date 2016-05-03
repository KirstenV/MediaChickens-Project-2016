using UnityEngine;
using System.Collections;

public class CameraScript : MonoBehaviour
{
    void Start()
    {
      
    }

    void OnTriggerEnter(Collider other)
    {

        
    }
    void OnTriggerExit(Collider other)
    {
        if(other.gameObject.tag == "Environment")
        {
            Destroy(other.gameObject);
        }
    }
}
