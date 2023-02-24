notifyEvent()

function notifyEvent(){
    setInterval(() => {
        var obj = new XMLHttpRequest();
        obj.onreadystatechange = async function(){
            if(this.readyState == 4 && this.status == 200){
                var response = this.responseText;
                if(response == '2') return
                const notifications = JSON.parse(response)
                for(const obj of notifications){
                    const timeOver = await checkTimeOver(obj.dateAndTime)
                    if(timeOver){
                        const data = await getData(obj.notifyId)
                        if(data) hasPermission(data)
                    } 
                }
            }
        };
        obj.open("POST","./ajax.php");
        obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        obj.send("getAllNotification=1");
    }, 30000)
}

function checkTimeOver(dateAndTime){
    return new Promise(resolve => {
        const currentTime = new Date()
        const savedTime = new Date(dateAndTime)
        const ct = `${currentTime.getDate()}${currentTime.getHours()}${currentTime.getMinutes()}`
        const st = `${savedTime.getDate()}${savedTime.getHours()}${savedTime.getMinutes()}`
        resolve(ct === st)
    })
}

function hasPermission(data){
    if(Notification.permission === 'granted') showNotification(data)
    else{
        Notification.requestPermission()
        .then(permission => {
            console.log(permission);
            if(permission === 'granted') showNotification(data)
        })
        .catch(err => {
            console.log(err);
        })
    }
}

function showNotification(data){
    console.log(data);
    const notificationText = JSON.parse(data)
    let notification = new Notification(notificationText[0].title, {
        body: notificationText[0].desc
    })

    notification.onclick = (e) => {
        // window.location.href = notificationText[0].eventLink
        window.open(notificationText[0].eventLink, '_blank')
    }
}

function getData(id){
    return new Promise(resolve => {
        var obj = new XMLHttpRequest();
        obj.onreadystatechange = async function(){
            if(this.readyState == 4 && this.status == 200){
                var response = this.responseText;
                if(response == '2') resolve()
                else resolve(response)
            }
        };
        obj.open("POST","./ajax.php");
        obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        obj.send("getData="+id);
    })
}