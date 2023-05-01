function deleteEntry(event){
    let confirmed = confirm("Are you sure you want to delete this entry?");
    if(!confirmed){
        event.preventDefault();
        return;
    }
}