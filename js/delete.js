function deleteEntry(event){
    let confirmed = confirm("Are you sure you want to delete this entry?");
    if(confirmed){
        return true;
    }
    else{
        event.preventDefault();
        return false;
    }
}