export const is404 = function(err){
    return hasResponseAndStatus(err)  && 404 === err.response.status;
}

export const is422 = function(err){
    return hasResponseAndStatus(err) && 422 === err.response.status;
}
export const is400 = function(err){
    return hasResponseAndStatus(err) && 400 === err.response.status;
}


const hasResponseAndStatus = function(err){
    return err.response && err.response.status;
}