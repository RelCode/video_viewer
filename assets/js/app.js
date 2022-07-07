var navHeight = document.getElementsByTagName('nav')[0].clientHeight;
document.getElementById('main-container').style.height = 'calc(100% - '+navHeight+'px)'

var form = document.getElementById('form');
if(form){
    form.addEventListener('submit',function(e) {
        const inputFields = document.querySelectorAll('.must-fill')
        let valid = true;
        for (let i = 0; i < inputFields.length; i++) {
            if(((inputFields[i].type == 'text' || inputFields[i].type == 'hidden') && inputFields[i].value == '') || (inputFields[i].type == 'file' && inputFields[i].files.length == 0)){
                if(valid) valid = !valid; e.preventDefault(); //valid == true, make it false first
                if(inputFields[i].id == 'categories'){
                    document.getElementsByClassName('cat-header')[0].classList.add('no-text')
                    setTimeout(() => {
                        document.getElementsByClassName('cat-header')[0].classList.remove('no-text')
                    }, 2500);
                }else{
                    inputFields[i].classList.add('no-value')
                    setTimeout(() => {
                        inputFields[i].classList.remove('no-value')
                    }, 2500);
                }
            }
        }
    })
}
//when user uploads file, change the input:file element label
function fileUploaded(input){
    let name = input.value.split(/(\\|\/)/g).pop();
    if(name !== ''){
        input.nextElementSibling.innerHTML = name;
    }else{
        input.nextElementSibling.innerHTML = 'Choose File';
    }
}
var categories = [];
function catChange(value){
    if(categories == ''){
        categories.push(value);
    }else{
        if(!categories.includes(value)){
            categories.push(value)
        }else{
            let index = categories.indexOf(value)
            if(index > -1){
                categories.splice(index,1)
            }
        }
    }
    document.getElementById('categories').value = categories.join(',')
}