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
    private float lanesUsed = 0;
    //how far the enemies are spawned
    private float enemySpawnDistance = 200;
    private float distanceBetweenEnemies = 50;
    private float enemySpawnCount = 1;
    //random spawning different enemies
    private float bigEnemiesOnLine = 0; //number of bigger enemies being made on the same line  
    private float totalEnemiesOnLine = 0;
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
        Instantiate(car, new Vector3(middleRoad, carYPos, enemySpawnDistance + 5.6f), Quaternion.identity);
        Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, enemySpawnDistance), Quaternion.identity);
    }

    void OnTriggerEnter(Collider other)
    {
        if (other.gameObject.CompareTag("Enemy"))
        {
            Destroy(other.gameObject);
            EnemySpawn();
        }
        
    }
    void EnemySpawn()
    {
        //choosing random lane for enemy
        int randomNrLane = Random.Range(2, 5); //1 left, 2 middle, 3 right
        //choosing random enemy object
        int randomNrEnemy = Random.Range(1, 4);
        if(bigEnemiesOnLine == 2)
        {
            randomNrEnemy = 3;
        }
        if(lanesUsed == randomNrLane)
        {
            if(lanesUsed != 4)
            {
                randomNrLane++;
            }
            else
            {
                randomNrLane--;
            }
        }
        if(lanesUsed >= 5)
        {
            if(lanesUsed == 5) // left and middle used (2+3)
            {
                randomNrLane = 4;
            }
            else if(lanesUsed == 6)//left and middle used (2+4) 
            {
                randomNrLane = 3;
            }
            else if(lanesUsed == 7) // middle and right used (3+4)
            {
                randomNrLane = 2;
            }
        }
        switch (randomNrEnemy)
        {
            case 1:
                bigEnemiesOnLine++;
                if (randomNrLane == 2)
                {
                    Instantiate(car, new Vector3(leftRoad, carYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(car, new Vector3(middleRoad, carYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else if(randomNrLane == 4)
                {
                    Instantiate(car, new Vector3(rightRoad, carYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 1"); }
                break;
                
            case 2:
                bigEnemiesOnLine++;
                if (randomNrLane == 2)
                {
                    Instantiate(truck, new Vector3(leftRoad, truckYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(truck, new Vector3(middleRoad, truckYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else if (randomNrLane == 4)
                {
                    Instantiate(truck, new Vector3(rightRoad, truckYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 2"); }
                break;

            case 3:
                if (randomNrLane == 2)
                {
                    Instantiate(roadBlock, new Vector3(leftRoad, roadblockYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else if (randomNrLane == 3)
                {
                    Instantiate(roadBlock, new Vector3(middleRoad, roadblockYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else if (randomNrLane == 4)
                {
                    Instantiate(roadBlock, new Vector3(rightRoad, roadblockYPos, enemySpawnDistance + distanceBetweenEnemies * enemySpawnCount), Quaternion.identity);
                }
                else { Debug.Log("Couldn't spawn enemy in this lane: 3"); }
                break;

            default:
                Debug.Log("Couldn't spawn this type of enemy");
                break;

        }
        lanesUsed += randomNrLane;
        totalEnemiesOnLine++;
        if (totalEnemiesOnLine == 3)
        {
            totalEnemiesOnLine = 0;
            enemySpawnCount++;
            bigEnemiesOnLine = 0;
            lanesUsed = 0;
        }
    }
}
