/**
 * File used for get all the information
 * about the base url and can know
 * what is the information to will use
 * like base for the url
 **/

/**
 * Function for know what is the url base and
 * can load libraries or files for use during the
 * execution of the file
 *
 * @return void
 * @author blackfoxgdl <ruben.alonso21@gmail.com>
 **/
function getBaseUrl()
{
    var url = location.href;
    var base = url.substring(0, url.indexOf('/', 14));
    if(base.indexOf('http://zavordigital.com/chiquimundo') != -1)
    {
        //BASE FOR LOCALHOST
        var url_inside = location.href;
        var pathname = location.pathname;
        var url1 = url_inside.indexOf(pathname);
        var url2 = url_inside.indexOf('/', url1 + 1);
        var localbase = url.substring(0, url2);
        return localbase;
    }
    else
    {
        return base;
    }
}
