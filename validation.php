<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
        <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="icon_document_alt"></i>Validation</h3>

          <div class="col-md-6 portlets">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="pull-left">Information</div>
                  <div class="widget-icons pull-right">
                  </div>  
                  <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                                      <div class="form quick-post">
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal" method="POST" action="submitValidation.php">
                                          <!-- Title -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="title">Start Date</label>
                                            
                                            <div class="col-lg-10"> 
                                              <input type="date" class="form-control" name="dateFrom" id="dateFrom">
                                            </div>
                                          </div>
                                      <!-- Title -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="dateTo">End Date</label>
                                            <div class="col-lg-10"> 
                                              <input type="date" class="form-control" name="dateTo" id="dateTo"/>
                                            </div>
                                          </div>                                              
                                          <!-- Title -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="title">Surveyor</label>
                                            <div class="col-lg-10"> 
                                              <input type="text" class="form-control" name="surveyor" id="surveyor">
                                            </div>
                                          </div>
                                          <!-- Title -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="inputBy">Input by</label>
                                            <div class="col-lg-10"> 
                                              <input type="text" class="form-control" name="inputBy" id="inputBy">
                                            </div>
                                          </div>
                                          <!-- Title -->
                                          <div class="form-group">
                                              <label class="control-label col-lg-2" for="area">Area validated</label>
                                            <div class="col-lg-10"> 
                                              <input type="text" class="form-control" name="area" id="area">
                                            </div>
                                          </div>                                          
                                          <!-- Title -->
                                          <div class="form-group">
                                            <label class="control-label col-lg-2" for="title">Site Code</label>
                                            <div class="col-lg-10"> 
                                              <input type="text" class="form-control" name="siteCode" id="siteCode">
                                              <script type="text/javascript">
                                              $(document).ready(function() {
                                                $(window).keydown(function(event){
                                                  if(event.keyCode == 13) {
                                                      event.preventDefault();
                                                      return false;
                                                  }
                                                });
                                              });
											  
                                              $("#siteCode").blur(function (event){
                                                  
                                            
                                                    var id = document.getElementById("siteCode").value;
                                                   
                                                    if(id ==""){
														                            return;
                                                    }else{
                                                      if (window.XMLHttpRequest) {
                                                        xmlhttp = new XMLHttpRequest();
                                                      }
                                                    xmlhttp.onreadystatechange = function() {
                                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                                        document.getElementById("plantationTable").innerHTML=xmlhttp.responseText;
                                                        }
                                                    };
                                                    xmlhttp.open("GET","getSiteSpecies.php?id="+id,true);
                                                    xmlhttp.send();
                                                    } //end of else


                                              });//end of keyup function
                                            
                                            
                                              </script>
                                              
                                            </div>
                                          </div>
                      <section class="panel">
                          <header class="panel-heading">
                              Current Plantation
                          </header>
                          <table class="table table-striped" id="plantationTable">
                              <thead>
                              <tr>
                                  <th>Species</th>
                                  <th>Quantity</th>
                                  <th>Height</th>
                                  <th>Diameter</th>
                              </tr>
                              </thead>
                              <tbody>
                              
                              </tbody>
                          </table>
                          <button type="button" class="btn btn-success btn-xs btn-block" id="addRowButton">+ Add Row</button>
                      </section>
                                          
                                          <!-- Buttons -->
                                          <div class="form-group">
                                             <!-- Buttons -->
                       <div class="col-lg-offset-2 col-lg-9">
                        <button type="submit" class="btn btn-success">Submit</button>
                       </div>
                                          </div>
                                      </form>
                                    </div>
                                    </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div>
              </div>
              
            </div>

        </div>
      </div>
          </section>
      </section>

	  
<script type="text/javascript">
  document.getElementById("addRowButton").addEventListener("click", addrow);
  var counter = 1;
  function addrow(){
    var tableRef = document.getElementById('plantationTable').getElementsByTagName('tbody')[0];
    var newRow   = tableRef.insertRow(tableRef.rows.length);
    var speciesName = newRow.insertCell(0);
    var quantity = newRow.insertCell(1);
    var height  = newRow.insertCell(2);
    var diameter  = newRow.insertCell(3);

    speciesName.innerHTML = "<input type=text name=species[]></input>";
    quantity.innerHTML = "<input type=text name=quantity[]></input>";
    height.innerHTML = "<input type=text name=height[]></input>";
    diameter.innerHTML = "<input type=text name=diameter[]></input>";
	
	}
	
</script>
  <script>

      //knob
      $(function() {
        $(".knob").knob({
          'draw' : function () { 
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
          $("#owl-slider").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
    
    /* ---------- Map ---------- */
  $(function(){
    $('#map').vectorMap({
      map: 'world_mill_en',
      series: {
        regions: [{
          values: gdpData,
          scale: ['#000', '#000'],
          normalizeFunction: 'polynomial'
        }]
      },
    backgroundColor: '#eef3f7',
      onLabelShow: function(e, el, code){
        el.html(el.html()+' (GDP - '+gdpData[code]+')');
      }
    });
  });



  </script>
