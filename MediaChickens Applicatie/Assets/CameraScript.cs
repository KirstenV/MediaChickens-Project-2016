using UnityEngine;
using System.Collections;

public class CameraScript : MonoBehaviour
{
    private byte obstaclesInGame = 1;
    public GameObject roadBlock;
    
    private float leftRoad = -33.3f;
    private float middleRoad = 35.6f;
    private float rightRoad = 104.4f;
    // Use this for initialization
    void Start()
    {

    }

    // Update is called once per frame
    void Update()
    {

    }
    void FixedUpdate()
    {
        EnemySpawn();

    }
    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.CompareTag("Enemy"))
        {
            Destroy(other.gameObject);
            obstaclesInGame--;
        }
    }
    void EnemySpawn()
    {
        if (obstaclesInGame < 2)
        {

            
            obstaclesInGame++;
            int randomNr = Random.Range(1, 4);
            switch (randomNr)
            {
                case 1:
                    Debug.Log("left Road");
                    Instantiate(roadBlock, new Vector3(leftRoad, 9f, this.transform.position.z + 100), Quaternion.identity);
                    break;
                case 2:
                    Debug.Log("middle Road");
                    Instantiate(roadBlock, new Vector3(middleRoad, 9f, this.transform.position.z + 100), Quaternion.identity);
                    break;
                case 3:
                    Debug.Log("right Road");
                    Instantiate(roadBlock, new Vector3(rightRoad, 9f, this.transform.position.z + 100), Quaternion.identity);
                    break;
                default:
                    Debug.Log("couldn't spawn enemy");
                    break;

            }
        }
    }
}
