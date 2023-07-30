<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>

<script>
    var config = {
          apiKey: "879e57e0187adced867bed96db02c026a5c19922",
          authDomain: "captainsaudi-3e143.firebaseapp.com", 
          databaseURL: "https://captainsaudi-3e143.firebaseio.com",
          storageBucket: "captainsaudi-3e143.appspot.com", 
          messagingSenderId: "9",
      };
        
        firebase.initializeApp(config);
        firebase.database().ref('/Delegates/'+'{{$id}}').remove(); 
        firebase.database().ref('/Locations/'+'{{$id}}').remove(); 
        firebase.database().ref('/Status/'+'{{$id}}').remove();
       
</script>  

