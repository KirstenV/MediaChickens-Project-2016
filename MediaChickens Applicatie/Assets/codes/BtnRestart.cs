﻿using UnityEngine;

public class BtnRestart : MonoBehaviour {
    //script only for reset button, hereby resetting the scene
    public void OnClick()
    {
        UnityEngine.SceneManagement.SceneManager.LoadScene("scene_AntwerpRunner");
    }
}
