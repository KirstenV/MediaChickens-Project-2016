using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using LitJson;

public class login : MonoBehaviour {
    //en nu par tests uitvoeren 
    //=>verkeerde email invoeren juiste pasword  variabel="lol"    500 iternal server error => hie moeten wij --> email is invalid krijgen
    //=>alles fou           klopt niet => imail heeft wel juist "constructie naam @ its . iets"                        500 iternal blabla = hier moeten we => bebreuker bestaat niet krijgen
    //=>email juist pasword fout                     WWW Ok!: {"success":"false","User":"Gebruiker bestaat niet"} dat kan niet echt verkeerd maar het werkt zelfde
    // klopt dit? nier helemaal )-: welke niet?
    //  en 500 error mag eigelijk niet opdagen 
    // ik ga 10 min anpasingen in script bij mij anbrengen en moeten dan nog eens testen
    //ok is goe 
    // okey ik laat je even 
    // is goe tot strax :)
    public Text txtEmail;
    public Text txtPassWord;
    public Text txtError;
    string email;
    string passWord;
    string stringError;
    void Start()
    {
        string url = "http://mediachickens.multimediatechnology.be/unity/login";

        WWWForm form = new WWWForm();
        form.AddField("email", "paraplu");
        form.AddField("password", "1234");
        WWW www = new WWW(url, form);

        StartCoroutine(WaitForRequest(www));
    }

    IEnumerator WaitForRequest(WWW www)
    {
        yield return www;

        // check for errors
        if (www.error == null)
        {

            Debug.Log("WWW Ok!: " + www.text);
            JsonData dataProjects = JsonMapper.ToObject(www.text);
            if (dataProjects["success"].ToString() == "True")
            {
                //user is correct
            }
            else
            {
                stringError = "";
                for (int i = 0; i < dataProjects["errors"].Count; i++)
                {
                    for (int j = 0; j < dataProjects["errors"][i].Count; j++)
                    {
                        stringError += dataProjects["errors"][i][j] + "\n";
                    }
                }
                txtError.text = stringError;
               // Debug.Log(dataProjects["errors"]);
                //Debug.Log(dataProjects["errors"][0][0]);
                // if(dataProjects["errors"])
            }
                /*if (dataProjects["errors"]["email"] != null)
                {
                    Debug.Log(dataProjects["errors"]["email"][0]);
                    ;
                }*/
       /* idd het is om struktuur te begrijpen dus wij moeten deze nabouwen
        @if($errors->has())
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
        @endif    

        */
            // ik denk ik weet waar probleem ziet 
            /*
            foreach(string error in dataProjects["errors"])
                {
                    Debug.Log(error);
                }*/
            //wat denk je?
            //kzat eerder te denke da we mss zitte te zoeke naar string die er ni is
            // dataProjects["errors"] type jsondata != string
        }
    
        
        else
        {
            Debug.Log("WWW Error: " + www.error);
        }
    }
    private void btnLoginClicked()
    {
        email = txtEmail.text;
        passWord = txtPassWord.text;
    }

}
