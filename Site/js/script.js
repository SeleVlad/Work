function _(x){
	return document.getElementById(x);
	
}
window.onload = function(){
	_('loginanchor').onclick = function(){
		_('loginanchor').style.backgroundColor = '#3195c9';
		_('loginanchor').style.color = '#fff';
		_('supanchor').style.background = 'none';
		_('supanchor').style.color = '#434343';
		_('login').style.display = "block";
		_('supfrm').style.display = 'none';
		return false;
		}
		_('supanchor').onclick = function(){
		_('supanchor').style.backgroundColor = '#3195c9';
		_('supanchor').style.color = '#fff';
		_('loginanchor').style.background = 'none';
		_('loginanchor').style.color = '#434343';
		_('supfrm').style.display = "block";
		_('login').style.display = 'none';
		return false;
		}
		
		_('x').onclick = function() {
			_('loginanchor').style.background = 'none';
			_('loginanchor').style.color = '#434343';
			_('login').style.display = 'none';
			}
		_('x2').onclick = function() {
			_('supanchor').style.background = 'none';
			_('supanchor').style.color = '#434343';
			_('supfrm').style.display = 'none';
			}
			}