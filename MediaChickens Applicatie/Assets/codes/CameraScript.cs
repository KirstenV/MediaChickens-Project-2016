using UnityEngine;
using System.Collections;
using UnityEngine.UI;

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
