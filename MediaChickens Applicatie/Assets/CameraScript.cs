using UnityEngine;
using System.Collections;

public class CameraScript : MonoBehaviour
{
    public GameObject roadBlock;
    public GameObject car;
    public GameObject truck;
    public GameObject road;
    public GameObject roadTrigger;
    //position of the player on the lanes
    private float leftRoad = 28;
    private float middleRoad = 36;
    private float rightRoad = 44;
    //how far the enemies are spawned
    private float enemySpawnDistance = 160;
    private float roadSpawnDistance = 230;
    //random spawning different enemies
    private float bigEnemiesOnLine = 0; //number of bigger enemies being made on the same line  
    //coördinates for spawning
    private float roadblockYPos = 1.7f;
    private float carYPos = 0;
    private float truckYPos = 0;
    


    void Start()
    {
        //making first enemies, always the same ones
        Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, enemySpawnDistance / 2), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, enemySpawnDistance / 2), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, enemySpawnDistance / 2), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, enemySpawnDistance - (enemySpawnDistance / 4)), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, enemySpawnDistance - (enemySpawnDistance / 4)), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, enemySpawnDistance - (enemySpawnDistance / 4)), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, enemySpawnDistance), Quaternion.identity);
        Instantiate(car, new Vector3(middleRoad, carYPos, enemySpawnDistance), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, enemySpawnDistance), Quaternion.identity);
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
        if (other.gameObject.CompareTag("TriggerRoadSpawn"))
        {
            Destroy(other.gameObject);
            RoadSpawn();
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
                    Instantiate(car, new Vector3(leftRoad, carYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 2)
                {
                    Instantiate(car, new Vector3(middleRoad, carYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else if(randomNrLane == 3)
                {
                    Instantiate(car, new Vector3(rightRoad, carYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 1"); }
                break;
                
            case 2:
                if (randomNrLane == 1)
                {
                    Instantiate(truck, new Vector3(leftRoad, truckYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 2)
                {
                    Instantiate(truck, new Vector3(middleRoad, truckYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(truck, new Vector3(rightRoad, truckYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 2"); }
                break;

            case 3:
                if (randomNrLane == 1)
                {
                    Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 2)
                {
                    Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, this.transform.position.z + enemySpawnDistance), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 3"); }
                break;

            default:
                Debug.Log("Couldn't spawn this type of enemy");
                break;

        }
        Debug.Log("end of spawn");
    }

    void RoadSpawn()
    {
        Debug.Log("new road incoming");
        Instantiate(road, new Vector3(35.2f, 0.002f, this.transform.position.z + 230), Quaternion.identity);
        Instantiate(roadTrigger, new Vector3(35.13f, 10, this.transform.position.z + 230), Quaternion.identity);
    }
}
