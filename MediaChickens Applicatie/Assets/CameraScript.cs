using UnityEngine;
using System.Collections;

public class CameraScript : MonoBehaviour
{
    public GameObject roadBlock;
    public GameObject car;
    public GameObject truck;
    //position of the player on the lanes
    private float leftRoad = 28;
    private float middleRoad = 36;
    private float rightRoad = 44;
    //how far the enemies are spawned
    private float spawnDistance = 160;
    //random spawning different enemies
    private float bigEnemiesOnLine = 0; //number of bigger enemies being made on the same line  
    //height for spawning
    private float roadblockYPos = 1.7f;
    private float carYPos = 0f;
    private float truckYPos = 1;
    // Use this for initialization
    void Start()
    {
        //making first enemies, always the same ones
        Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, spawnDistance/2), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, spawnDistance/2), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, spawnDistance/2), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, spawnDistance - (spawnDistance/4)), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, spawnDistance - (spawnDistance / 4)), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, spawnDistance - (spawnDistance / 4)), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, spawnDistance), Quaternion.identity);
        Instantiate(car, new Vector3(middleRoad, roadblockYPos, spawnDistance), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, spawnDistance), Quaternion.identity);
    }

    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.CompareTag("Enemy"))
        {
            Destroy(other.gameObject);
            EnemySpawn();
        }
        if(other.gameObject.CompareTag("EnemyTrigger"))
        {
            Destroy(other.gameObject);
            EnemySpawn();
            EnemySpawn();
        }
    }
    void EnemySpawn()
    {
        //choosing random lane for enemy
        int randomNrLane = Random.Range(1, 4); //1 left, 2 middle, 3 right
        //choosing random enemy object
        int randomNrEnemy = Random.Range(1, 4);
        switch (randomNrEnemy)
        {
            case 1:
                if (randomNrLane == 1)
                {
                    Instantiate(car, new Vector3(leftRoad, carYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 2)
                {
                    Instantiate(car, new Vector3(middleRoad, carYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else if(randomNrLane == 3)
                {
                    Instantiate(car, new Vector3(rightRoad, carYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 1"); }
                break;
                
            case 2:
                if (randomNrLane == 1)
                {
                    Instantiate(truck, new Vector3(leftRoad, truckYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 2)
                {
                    Instantiate(truck, new Vector3(middleRoad, truckYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(truck, new Vector3(rightRoad, truckYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 2"); }
                break;

            case 3:
                if (randomNrLane == 1)
                {
                    Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 2)
                {
                    Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, this.transform.position.z + spawnDistance), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 3"); }
                break;

            default:
                Debug.Log("Couldn't spawn this type of enemy");
                break;

        }
        Debug.Log("end of spawn");
    }
}
