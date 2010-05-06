/**
 * Site library
 *
 * @author Jon-Michael Deldin <dev@jmdeldin.com>
 */
var MA = {};

/**
 * Clears the search field.
 * 
 * @param string id  HTML ID of the search input
 * @param string val Value to clear
 */
MA.searchHandler = function(id, val){
    var input = document.getElementById(id);
    if (!input) {
        return false;
    }

    // initial value
    setDefault();

    input.onclick = function(){
        if (input.value === val) {
            input.value = "";
        }
    };

    input.onblur = setDefault;

    function setDefault(){
        if (!input.value) {
            input.value = val;
        }
    };
};

MA.searchHandler("q", "search");