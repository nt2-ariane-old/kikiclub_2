const errorlogger = (error) => {
    let infos = null
    if (error.response) {
        // console.log(error.response.data);
        if (typeof error.response.data.message !== 'undefined') {
            console.log(error.response.data.message)
        }
        console.log(error.response)
    } else if (error.request) {
        // infos = 'Requête invalide'
        console.log(error.request);
    } else {
        console.log(error.message)
    }
    console.log(error.config);
}
export default errorlogger