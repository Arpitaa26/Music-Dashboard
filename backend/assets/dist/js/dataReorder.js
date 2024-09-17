
        function updatedtorder(main_table,diff,api_url) {
          var ho = [];
          var hn = []; 
          main_table.rows().iterator('row', function(context, index) {
              var rowData = main_table.row(index).data();
              ho.push(rowData[1]);
              hn.push(rowData[1]);

          });

          
          for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
              hn[diff[i].newPosition]=ho[diff[i].oldPosition];
          }

          $.ajax({

              type: "POST",
              url: api_url,
              data: {
                  ids: " " + hn + ""
              },

              success: function() {

                  //window.location.reload();
              }

          });

          console.log(hn);
      }
