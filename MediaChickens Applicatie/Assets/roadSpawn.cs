using UnityEngine;
using System.Collections;

public class roadSpawn : MonoBehaviour {
    public GameObject road;
    public GameObject roadTrigger;
    private float roadSpawnDistance = 200;

    void FixedUpdate(){

    }
    void OnTriggerEnter(Collider other)
    {
        Debug.Log("trigger");
        if (other.gameObject.CompareTag("TriggerRoadSpawn"))
        {
            Debug.Log(other.gameObject.tag);
            Destroy(other.gameObject);
            RoadSpawn();
        }

    }

    void RoadSpawn()
    {
        Debug.Log("new road incoming");
        Instantiate(road, new Vector3(35.2f, 0.002f, this.transform.position.z + (roadSpawnDistance * 3)), Quaternion.identity);//230 35.2f
        Instantiate(roadTrigger, new Vector3(35.13f, 10, this.transform.position.z + roadSpawnDistance), Quaternion.identity);
        Debug.Log("spawned road");
    }
}
