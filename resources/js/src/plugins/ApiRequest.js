import {APIService} from '@/plugins/APIService';
class ApiRequest{
	static doLogin(api,rec,callback){
		APIService.post(api,rec).then(response => {
	        var data = response.data;
	        if(data != null){
	        	callback(data);
	        }else{
	        	this.showError('Login failed: Record is empty , please contact your admin');
	        }
	      })
	     .catch(e => {
	    	 var res = {'status':'error'};
	    	 if(e.response == null){
	    		 res.message = e.message;
	    	 }else{
	    		 res.message = e.response.data.message
	    	 }
	    	 callback(res);
	          //this.showError(e.response.data.message);
	     });
	}
	static doPost(api,rec,callback){
		APIService.defaults.headers.common['Authorization'] = 'Bearer ' + this.getTotken();
		APIService.post(api,rec).then(response => {
	        var data = response.data;
	        if(data != null){
	        	callback(data);
	        }else{
	        	this.showError('Record is empty , please contact your admin');
	        }
	      })
	     .catch(e => {
	    	 var res = {'status':'error'};
	    	 if(e.response == null){
	    		 res.message = e.message;
	    	 }else{
	    		 res.message = e.response.data.message
	    	 }
	    	 callback(res);
	          //this.showError(e.response.data.message);
	     });
	}
	static doGet(api,callback){
		APIService.defaults.headers.common['Authorization'] = 'Bearer ' + this.getTotken();
		APIService.get(api).then(response => {
	        var data = response.data;
	        if(data != null){
	        	callback(data.data);
	        }else{
	        	this.showError('Record is empty , please contact your admin');
	        }
	      })
	     .catch(e => {
	    	 var res = {'status':'error'};
	    	 if(e.response == null){
	    		 res.message = e.message;
	    	 }else{
	    		 res.message = e.response.data.message
	    	 }
	    	 callback(res);
	    	 //throw e;
	          //this.errors.push(e);
	          //this.showError(e.response.data.message);
	     });
	}
	static doPut(api,rec,callback){
		APIService.defaults.headers.common['Authorization'] = 'Bearer ' + this.getTotken();
		APIService.put(api,rec).then(response => {
	        var data = response.data;
	        if(data != null){
	        	callback(data);
	        }else{
	        	throw 'Record is empty , please contact your admin';
	        }
	      })
     .catch(e => {
    	 var res = {'status':'error'};
    	 if(e.response == null){
    		 res.message = e.message;
    	 }else{
    		 res.message = e.response.data.message
    	 }
    	 callback(res);
          //this.errors.push(e)
          //this.showError(e.response.data.message);
     });
	}
	static getTotken(){
		var author = JSON.parse(localStorage.getItem("apiData"));
		var token = "";
		if(author != null ){
			token = author.api_token;
		}
		if(token == null || token == ""){
			throw "Invalid token, token is empty";
		}
		return token;
	}
	static doDelete(api,callback){
		APIService.defaults.headers.common['Authorization'] = 'Bearer ' + this.getTotken();
		APIService.delete(api).then(response => {
	        var data = response.data;
	        if(data != null){
	        	callback(data);
	        }else{
	        	throw 'Record is empty , please contact your admin';
	        }
	      })
	     .catch(e => {
	    	 var res = {'status':'error'};
	    	 if(e.response == null){
	    		 res.message = e.message;
	    	 }else{
	    		 res.message = e.response.data.message
	    	 }
	    	 callback(res);
	          //this.errors.push(e);
	          //this.showError(e.response.data.message);
	     });
	}
}
export {ApiRequest}