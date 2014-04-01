<h1>Manage Documents</h1>
<!-- This table makes a box so that i can show a signature without it you cant -->
<p>List of all documents <button class="k-button" type="button" onclick="window.location='<?php echo $exepath; ?>documents/add'">Add Document</button></p>  

<div id="example" class="k-content">
  <div id="document_grid"  style="font-size:11px;"> </div>
  <br>
  <br>
  <div class = 'k-content k-state-active' id = "contentArea"> 

  </div>
  <br>
  <br>
  <div id = "Pad">
  </div>

  <script>

// function that returns the row and colomn of an element in a kendoGrid 
function onDataBound(e) 
{

  var grid = $("#document_grid").data("kendoGrid");
  $(grid.tbody).on("click", "td", function (e) 
  {
    var row = $(this).closest("tr");
    var rowIdx = $("tr", grid.tbody).index(row);
    var colIdx = $("td", row).index(this);
    alert(rowIdx + '-' + colIdx);
  });
}
    /*
    You can get the data through the dataItem() method only if you are using Ajax binding.
    When using server binding the data is not available and you neet to locate the row and get the
    HTML content. 
    THIS GETS A ROW: console.log(grid.tbody.find(">tr:first").html());
    */
    function consoleLogSelection(e)
    {
     var isSet = false;
     var grid = $("#document_grid").data("kendoGrid");
     $(grid.tbody).on("click", "td", function (e) 
     {
            // gets the signature cooridnates and outputs to console 
        var this_row = $(this).closest("tr"); // grabs the nearest row here user clicked
        var this_rowIdx = $("tr", grid.tbody).index(this_row);
        var colIdx = $("td", row).index(this);
           //alert(this_rowIdx + '-' + colIdx); // will show an alert in browser if needed 
        var row = grid.tbody.find(":nth-child("+ this_rowIdx +")").find(":nth-child(4)").html(); //giving me html row

        var sig = JSON.parse($("#document_grid").data("kendoGrid")._data[this_rowIdx].signature); //gives sig as JSON Object
        var pad = document.getElementById("Pad")
        var documentContent = $("#document_grid").data("kendoGrid")._data[this_rowIdx].content;
        console.log(documentContent);
        $("#document_grid").data("kendoGrid")._data[this_rowIdx].signature = document.getElementById("wrapsig"); //Gives an HTML form element  
        $("#document_grid").data("kendoGrid").refresh(); // refreshes the view after switching to hello
        
        /*
        Checking to see if this is the first time that a user 
        has a selected a document from the list if it is it creates
        a new k-textbox and and sets the flag
        */
        if(!isSet)
        {    
         var div = document.createElement('div');

         div.className = 'row';
         div.innerHTML = ' <td>This user has signed this document:<br><br></td><td valign="top"><form method="post" action="" class="sigPad" id="sigPadInput"><ul class="sigNav"><li class="clearButton"><a href="#clear" style="color: #000;">Clear</a></li></ul><div id = "wrapsig" class="sig sigWrapper"> <div class="typed"></div><canvas class="pad" width="98" height="55"></canvas><input type="hidden" name="output" class="output"></div> </form></td></tr>'; 
         document.getElementById('Pad').appendChild(div); 
         var sdiv = document.createElement('sdiv');

         sdiv.className = 'k-content k-state-active';

         sdiv.innerHTML = '<h2>Document Preview</h2><br><form id="documentForm2" action="<?php echo $exepath; ?>documents/save" method="POST" onsubmit="return submitForm();"><textarea class="k-textbox" id = "contentTextArea" style = "resize: none"; readonly rows="10" cols="100">  </textarea><br><button type="button" class="k-button" id="editButton">Edit Document</button></form>';
         document.getElementById('contentArea').appendChild(sdiv);   
         document.getElementById('contentTextArea').value = documentContent;
         /*
          Adds an onclick event to the editbutton under the document
          preview the other way was pretty hard. I was trying to 
          add it into a string literal and couldnt get the escape
          chararacter "/" in the right place. 
         */
         document.getElementById("editButton").onclick = function(){
                  //alert("We just edited this Shit!!!");
                  //window.location= "\<?php echo $exepath; ?>documents/add"; sends me to the edit doc page
                  $("#contentTextArea").kendoEditor();
         }
         isSet = true;        
       }
       else
       {
                document.getElementById('contentTextArea').value = documentContent;
        }



              $("#document_grid").data("kendoGrid")._data[this_rowIdx].signature =  $(document).ready(function () 
              {
                $('.sigPad').signaturePad({displayOnly:true}).regenerate(sig);
              });  

            });
}
$(document).ready(function() 
{
  $("#document_grid").kendoGrid(
  {
    dataSource: {
      type: "jsonp",
      serverPaging: true,
      serverSorting: true,
      pageSize: 30,
                //this reads in data from docments service, this is java script code
                transport: {
                  read: "<?php echo $exepath; ?>documents/documents_service"
                },

                schema: {
                  data: function(result) {
                    return result.Result || result;


                  },
                  total: function(result)
                  {
                    return result.PageSize || result.length || 0;
                  }
                }
              },
              dataBound: consoleLogSelection,
              scrollable: false,
              sortable: true,
              pageable: {
                pageSize: 30
              },
            // data binds to these columns have to open up the object 
            columns: [
            { field: "title", title: "Title", width: 90},
            { field: "document_id", title: "Doc ID", width: 60 },
            { field: "user_id", title: "User", width: 90 },
            { field: "date_added", title: "Date Added", width: 90 },
            ]

          });

});
</script>
</div>
