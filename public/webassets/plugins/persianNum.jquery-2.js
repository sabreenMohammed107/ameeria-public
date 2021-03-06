/**
 * Created by Mohammad Shobeiri 2018
 * mohammad.shobeiri@gmail.com
 * version 2.0.0
 */

jQuery.fn.persianNum = function (options,numberType) {
    $this = jQuery(this);
    persianNumClasses = options ? options.persianNumClasses || ['persian'] : ['persian'] ;
    englishNumClasses = options ? options.englishNumClasses || ['english'] : ['english'] ;
    arabicNumClasses = options ? options.arabicNumClasses || ['arabic'] : ['arabic'] ;
    forbiddenTag = options ? options.forbiddenTag || ['SCRIPT','STYLE', 'CODE'] : ['SCRIPT','STYLE', 'CODE'];
    for (var j = 0; j < this.length; j++) {
        var el = this[j];
        var className = typeof el.className == "string" ? getClasses(el) : [] ;
        if (forbiddenTag.indexOf(el.nodeName) >= 0)
            break;
        for (var i = 0; i < el.childNodes.length; i++) {
            var cnode = el.childNodes[i];
            if (cnode.nodeType == 3) {
                var nval = cnode.nodeValue;
                if (hasCommonElements(className, persianNumClasses) || numberType === 'p'){
                    cnode.nodeValue = traverse(nval);
                } else if (hasCommonElements(className, englishNumClasses) || numberType === 'e') {
                    cnode.nodeValue = traverseEn(nval);
                } else if (hasCommonElements(className, arabicNumClasses) || numberType ==='a') {
                    cnode.nodeValue = traverseAr(nval);
                }
            } else if (cnode.nodeType == 1) {
                if (hasCommonElements(getClasses(cnode), persianNumClasses) || numberType === 'p'){
                    if(cnode.nodeName == "OL")
                        jQuery(cnode).css("list-style-type","persian");
                    jQuery(cnode).persianNum({persianNumClasses:persianNumClasses, englishNumClasses:englishNumClasses,arabicNumClasses:arabicNumClasses, forbiddenTag:forbiddenTag},'p');
                } else if (hasCommonElements(getClasses(cnode), englishNumClasses) || numberType === 'e') {
                    if(cnode.nodeName == "OL")
                        jQuery(cnode).css("list-style-type","decimal");
                    jQuery(cnode).persianNum({persianNumClasses:persianNumClasses, englishNumClasses:englishNumClasses,arabicNumClasses:arabicNumClasses, forbiddenTag:forbiddenTag},'e');
                } else if (hasCommonElements(getClasses(cnode), arabicNumClasses) || numberType === 'a') {
                    if(cnode.nodeName == "OL")
                        jQuery(cnode).css("list-style-type","arabic-indic");
                    jQuery(cnode).persianNum({persianNumClasses:persianNumClasses, englishNumClasses:englishNumClasses,arabicNumClasses:arabicNumClasses, forbiddenTag:forbiddenTag},'a');
                }
                jQuery(cnode).persianNum({persianNumClasses:persianNumClasses, englishNumClasses:englishNumClasses,arabicNumClasses:arabicNumClasses, forbiddenTag:forbiddenTag});
            }
        }
        if (hasCommonElements(getAllClasses(el,'body'), ['realtime'])) {
            if (hasCommonElements(className, persianNumClasses) || numberType === 'p'){
                realtime(jQuery(this),options,'p');
            } else if (hasCommonElements(className, englishNumClasses) || numberType === 'e') {
                realtime(jQuery(this),options,'e');
            } else if (hasCommonElements(className, arabicNumClasses) || numberType === 'a') {
                realtime(jQuery(this),options,'a');
            }
        }
    }
};

function realtime(elm,options,numberType){
    elm.bind("DOMSubtreeModified",function(element){
        elm.unbind("DOMSubtreeModified");
        jQuery(element.target).persianNum(options,numberType,false);
    });
}
function hasCommonElements(array1, array2) {
    res = false;
    if (array1 == [] || array2 == [] ) return res;
    array1.forEach(function (element) {
        if (array2.indexOf(element) >= 0){
            res = true;
            return;
        }
    });
    return res;
}

function getClasses (elm) {
    return elm.className.split(' ');
}
function getAllClasses (from, until) {
    var cs = [];
    jQuery(from)
        .parentsUntil(until)
        .addBack()
        .each(function(){
            if (this.className)
                cs.push.apply(cs, this.className.split(' '));
        });
    return cs;
}

function traverseAr(str) {
    return str.replace(/0/g,'??').replace(/1/g,'??').replace(/2/g,'??').replace(/3/g,'??').replace(/4/g,'??')
        .replace(/5/g,'??').replace(/6/g,'??').replace(/7/g,'??').replace(/8/g,'??').replace(/9/g,'??')
        .replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??')
        .replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??');
}
function traverse(str) {
    return str.replace(/0/g,'??').replace(/1/g,'??').replace(/2/g,'??').replace(/3/g,'??').replace(/4/g,'??')
        .replace(/5/g,'??').replace(/6/g,'??').replace(/7/g,'??').replace(/8/g,'??').replace(/9/g,'??')
        .replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??')
        .replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??').replace(/??/g,'??');
}

function traverseEn(str) {
    return str.replace(/??/g,'0').replace(/??/g,'1').replace(/??/g,'2').replace(/??/g,'3').replace(/??/g,'4')
        .replace(/??/g,'5').replace(/??/g,'6').replace(/??/g,'7').replace(/??/g,'8').replace(/??/g,'9')
        .replace(/??/g,'0').replace(/??/g,'1').replace(/??/g,'2').replace(/??/g,'3').replace(/??/g,'4')
        .replace(/??/g,'5').replace(/??/g,'6').replace(/??/g,'7').replace(/??/g,'8').replace(/??/g,'9');
}