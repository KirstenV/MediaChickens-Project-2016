using UnityEngine;
using System.Collections;

public class BtnRestart : MonoBehaviour {

	// Use this for initialization
	void Start () {
	
	}
	
	// Update is called once per frame
	void Update () {
	
	}
    void OnClick()
    {
        UnityEngine.SceneManagement.SceneManager.LoadScene("swipeWorks");
    }
}
