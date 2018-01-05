		@extends('frontend.layouts.app')

		@section('title', 'Download')

		@section('content')
		<section id="company-box">
			<div class="container">
			<div class="row">
			
			<div class="col-md-2 ">
			<div style="background-color: white;padding: 6px;" >
			 <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Keyword">
				 </div>
				  </div> 
		<div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Name">
				 </div>
				  </div>   
				  <div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Industry </option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					 </select>
					 </div>  
					 <div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Industry </option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  
		<div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Degree">
				 </div>
				  </div>   
		<div class="form-group">
			   <div class="pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Institute">
				 </div>
				  </div>   
		<div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Job Tittle">
				 </div>
				  </div>   
		<div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Organization">
				 </div>
				  </div> 
			  <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Minimum Salary">
				 </div>
				  </div> 
			   <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Maximum Salary">
				 </div>
				  </div> 
				<div class=" pnj-form-field">
				<select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Currency </option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  		  
				 <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Minimum Experience">
				 </div>
				  </div> 
		<div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Maximum Experience">
				 </div>
				  </div> 
		  <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Skills">
				 </div>
				  </div> 	
		  <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Minimum Age">
				 </div>
				  </div> 	
		  <div class="form-group">
			   <div class=" pnj-form-field">
				 <input type="text" class="form-control" name="vacancy" placeholder="Maximum Age">
				 </div>
				  </div>
			<div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Currency </option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  
			<div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Gender</option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  
			 <div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Marital Status</option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>   <div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">Country </option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  
			 <div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">State</option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  
			  <div class=" pnj-form-field">
			  <select class="form-control select2" name="shift">
		   
				  <option value="Industry ">City </option>
				  <option value="Industry ">Accounting </option>
				  <option value="Industry ">Computer</option>
					
					 </select>
					 </div>  	
			 <button type="submit" class="btn btn-primary">Save</button>			 
										  
			</div>
		  </div>
				<div class="col-md-8 company-box-left">
				<span>No records found.</span>
				   
				</div>
			   
				 
			</div>
		</section>
		@endsection
		@section('page-footer')
		<script type="text/javascript">
		</script>
		@endsection