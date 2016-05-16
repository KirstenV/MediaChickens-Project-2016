using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class CameraScript : MonoBehaviour
{
    //public GameObject objectname = GameObject.Instantiate(Resources.Load("HoverText")) as GameObject;
    // GUIText nameGUI = objectname.GetComponent<GUIText>();
    public TextMesh txtTunnel;
 //   public GameObject buildingProject;
 //   public Text txtProjectName;
    void Start()
    {
        txtTunnel.text = "Antwerpen";
        //txtTunnel.transform.position = new Vector3(0,0,0);
        //   txtProjectName.transform.position = Camera.main.WorldToViewportPoint(transform.position) + new Vector3(buildingProject.transform.position.x, buildingProject.transform.position.y + SomeYOffset, buildingProject.transform.position.z + 400);
        //writeOnGameobject.transform.position = new Vector3(objectTunnel.transform.position.x, objectTunnel.transform.position.y + SomeYOffset, objectTunnel.transform.position.z);
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
