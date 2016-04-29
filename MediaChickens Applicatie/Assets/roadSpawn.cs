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
        if (other.gameObject.CompareTag("TriggerRoadSpawn"))
        {
            Destroy(other.gameObject);
            RoadSpawn();
        }

    }

    void RoadSpawn()
    {
        Instantiate(road, new Vector3(35.2f, 0.002f, this.transform.position.z + (roadSpawnDistance * 3)), Quaternion.identity);//230 35.2f
        Instantiate(roadTrigger, new Vector3(35.13f, 10, this.transform.position.z + roadSpawnDistance), Quaternion.identity);
    }
}
