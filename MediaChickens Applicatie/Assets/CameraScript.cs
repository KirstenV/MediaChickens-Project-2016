using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class CameraScript : MonoBehaviour
{
   /*public GameObject objectname = GameObject.Instantiate(Resources.Load("HoverText")) as GameObject;
   GUIText name = objectname.GetComponent<GUIText>();
    float SomeYOffset = 100f;
    public GameObject buildingProject;
    public Text txtProjectName;*/
    void Start()
    {
     //   txtProjectName.transform.position = Camera.main.WorldToViewportPoint(transform.position) + new Vector3(buildingProject.transform.position.x, buildingProject.transform.position.y + SomeYOffset, buildingProject.transform.position.z + 400);
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
