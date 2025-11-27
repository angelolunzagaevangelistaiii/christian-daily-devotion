let btn=document.getElementById('mark-read');
if(btn){
    btn.addEventListener('click',function(){
        let id=this.getAttribute('data-id');
        fetch('mark_read.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'id='+id
        }).then(res=>res.text()).then(data=>{
            if(data=='read'){
                this.innerText='Read ✅';
                this.disabled=true;
            }
        });
    });
}
