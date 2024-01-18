var a;
function pass()
{
    if(a == 1)
    {
        document.getElementById('lozinka').type='password';
        document.getElementById('pass-icon').src ='../img/pass-hide.png';
        a = 0;
    }
    
    else {
        document.getElementById('lozinka').type = 'text';
        document.getElementById('pass-icon').src = '../img/pass-show.png';
        a = 1;
    }
}