(function (Drupal) {
  "use strict";

  //   /**
  //    * @file
  //    * Integrates flmngrWidget into file field widgets.
  //    */

  //   /**
  //    * Global container for helper methods.
  //    */

  var flmngrWidget = {};
  var flmngrFieldId;

  /**
   * Drupal behavior to handle flmngrWidget file field integration.
   */

  Drupal.behaviors.flmngrWidget = {
    attach: function (context, settings) {
      function includeJS(urlJS, doc, callback) {
        if (!doc) {
          doc = document;
        }
        var scripts = doc.getElementsByTagName("script");
        var alreadyExists = false;
        var existingScript = null;
        for (var i = 0; i < scripts.length; i++) {
          var src = scripts[i].getAttribute("src");
          if (src && src.indexOf(urlJS) !== -1) {
            alreadyExists = true;
            existingScript = scripts[i];
          }
        }
        if (!alreadyExists) {
          var script = doc.createElement("script");
          script.type = "text/javascript";
          if (callback != null) {
            if (script.readyState) {
              // IE
              script.onreadystatechange = function () {
                if (
                  script.readyState === "loaded" ||
                  script.readyState === "compvare"
                ) {
                  script.onreadystatechange = null;
                  callback(false);
                }
              };
            } else {
              // Others
              script.onload = function () {
                callback(false);
              };
            }
          }
          script.src = urlJS;
          doc.getElementsByTagName("head")[0].appendChild(script);
          return script;
        } else {
          if (callback != null) {
            callback(true);
          }
          return null;
        }
      }

      function setupNow(flmngr) {
        flmngrWidget.flmngrInstance = flmngr;
        var i;
        var el;
        var els = context
          .querySelectorAll(".flmngrWidget-filefield-paths")
          .forEach(function (node) {
            if (!node.classList.contains("iff-processed")) {
              node.classList.add("iff-processed");
              flmngrWidget.processInput(node);
            }
          });

        // for (i = 0; i < els.length; i++) {
        //   flmngrWidget.processInput(els[i]);
        // }
      }
      function waitForFlmngr() {
        var instances = window.CKEDITOR.instances;
        var instanceKey = Object.keys(instances).find(function (key) {
          return instances[key].flmngr != undefined;
        });

        if (instanceKey) {
          setupNow(instances[instanceKey].flmngr);
        } else {
          setTimeout(function () {
            waitForFlmngr();
          }, 100);
        }
      }

      function includeFM(standaloneData, imgpenInstance) {
        if (standaloneData && !window.flmngr) {
          includeJS(standaloneData.standaloneSrc, document, function (status) {
            waitForFlmngrStandalone(standaloneData, imgpenInstance);
          });
        } else if (standaloneData && window.flmngr) {
          setupNow(
            window.flmngr.create({
              integration: "drupal8",
              urlFileManager: standaloneData.standaloneUrl,
              urlFiles: standaloneData.standaloneUrlFiles,
              defaultUploadDir: standaloneData.standaloneDirUploads,
              urlFileManager__CSRF: getCSRFToken,
              imgPen: imgpenInstance,
            })
          );
        }
      }

      function waitForImgPen(standaloneData) {
        if (window.imgpen) {
          var imgpenInstance = window.imgpen.create({
            integration: "drupal8",
          });
          includeFM(standaloneData, imgpenInstance);
        } else {
          setTimeout(function () {
            waitForImgPen(standaloneData);
          }, 100);
        }
      }

      function waitForFlmngrStandalone(standaloneData, imgpenInstance) {
        if (window.flmngr) {
          setupNow(
            window.flmngr.create({
              urlFileManager: standaloneData.standaloneUrl,
              urlFiles: standaloneData.standaloneUrlFiles,
              integration: "drupal8",
              defaultUploadDir: standaloneData.standaloneDirUploads,
              urlFileManager__CSRF: getCSRFToken,
              imgPen: imgpenInstance,
            })
          );
        } else {
          setTimeout(function () {
            waitForFlmngrStandalone(standaloneData, imgpenInstance);
          }, 100);
        }
      }

      function editorReady(e) {
        var editor = e.editor;
        //Using free version without FM
        if (editor.plugins.WidgetsFree) {
          return;
        }

        if (editor.plugins.Flmngr) {
          waitForFlmngr();
        } else {
          //For some other reason FM not present(turned off by user)
          return;
        }
      }

      function getCSRFToken(onSuccess, onError) {
        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
          if (req.readyState == XMLHttpRequest.DONE) {
            if (req.status == 200) {
              onSuccess({
                headers: {
                  "X-CSRF-Token": req.responseText,
                },
              });
            } else {
              onError();
            }
          }
        };

        req.open(
          "GET",
          window.drupalSettings.path.baseUrl + "session/token",
          true
        );
        req.send();
      }

      var standaloneData;
      if (window.CKEDITOR && window.CKEDITOR.instances) {
        waitForFlmngr();
      } else {
        var el;
        var i;
        var $els = context
          .querySelectorAll(".flmngrWidget-filefield-paths")
          .forEach(function (node) {
            if (node.dataset.standalonedata) {
              standaloneData = node.dataset;
            }
          });

        if (standaloneData && !window.imgpen) {
          standaloneData = JSON.parse(standaloneData.standalonedata);
          includeJS(
            standaloneData.standaloneimgpen,
            document,
            function (status) {
              waitForImgPen(standaloneData);
            }
          );
        } else if (standaloneData && window.imgpen) {
          standaloneData = JSON.parse(standaloneData.standalonedata);
          var imgpenInstance = window.imgpen.create({ integration: "drupal8" });
          includeFM(standaloneData, imgpenInstance);
        }
      }
    },
  };

  /**
   * Processes an flmngrWidget file field input to create a widget.
   */
  flmngrWidget.processInput = function (el) {
    var widget;
    var fieldId = (flmngrFieldId = el
      .getAttribute("data-drupal-selector")
      .split("-flmngrWidget-paths")[0]);
    if (el.parentNode.parentNode.querySelector("label")) {
      el.parentNode.parentNode.querySelector("label").removeAttribute("for");
    } else if (el.parentNode.parentNode.parentNode.querySelector("label")) {
      el.parentNode.parentNode.parentNode
        .querySelector("label")
        .removeAttribute("for");
    }

    if (fieldId) {
      widget = flmngrWidget.createWidget(
        el.dataset.extensions,
        fieldId,
        el.dataset.multiple == 1
      );
      el.parentNode.prepend(widget);
      widget.parentNode.className += " flmngrWidget-filefield-parent";
    }
    return widget;
  };

  /**
   * Creates an flmngrWidget file field widget with the given url.
   */
  flmngrWidget.createWidget = function (extensions, fieldId, multipleFlag) {
    var elBtn = document.createElement("button");
    elBtn.classList.add("button");
    var img = document.createElement("img");
    img.src =
      "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAqElEQVR4nGNgGIzAG4gfAfF/NPwIKkc0eIrFEGLwcXSDYBLoYDcRhhFlED6AoYcJTcFBIlyBbACMfxiZY0KkIdjwQ2QXRUDpXiBmJBL3QvVsRHbRQySXEQtgemyQDYIZRizQg+p5DsRM6IG9mgSDwqH0WiD+h+4iUrx1E6rHDiZAjrd0oHpeAzELSADZa6R4KxRKbwLiP+guIge7IJv+kUxDTsK8RVUAANqYfPlyBv+kAAAAAElFTkSuQmCC";
    var span = document.createElement("span");
    span.innerText = "Browse";
    elBtn.append(img);
    elBtn.append(span);

    var fieldId_cleansed = fieldId.replace("-n1ed-paths", "");
    fieldId_cleansed = fieldId_cleansed.replace("edit-", "");
    var elFileInput;
    if (multipleFlag) {
      elFileInput = document.querySelector(
        "input[name='files[" + fieldId_cleansed.replace(/-/g, "_") + "][]']"
      );
    } else {
      elFileInput = document.querySelector(
        "input[name='files[" + fieldId_cleansed.replace(/-/g, "_") + "]']"
      );
    }
    elFileInput.style.display = "none";
    elBtn.addEventListener("click", function (e) {
      flmngrWidget.eLinkClick(e, extensions, fieldId, multipleFlag);
    });

    var elUploadButton = document.createElement("button");
    elUploadButton.classList.add("button");
    elUploadButton.innerText = "Upload";
    elUploadButton.addEventListener("click", function (e) {
      var evt = document.createEvent("MouseEvents");
      evt.initEvent("click", true, false);
      elFileInput.dispatchEvent(evt);
      e.preventDefault();
    });

    var result = document.createElement("div");
    result.classList.add("flmngrWidget");
    result.append(elBtn);
    result.append(elUploadButton);

    return result;
  };

  /**
   * Click event for the browser link.
   */
  flmngrWidget.eLinkClick = function (e, extensions, fieldId, multipleFlag) {
    e.preventDefault();
    flmngrWidget.flmngrInstance.browse({
      acceptExtensions: extensions.split(" "),
      isMultiple: multipleFlag,
      onCancel: function () {},
      onFinish: function (urls) {
        flmngrWidget.onFinish(fieldId, urls, multipleFlag);
      },
    });
  };

  /**
   * Submits a field widget with selected file paths.
   */
  flmngrWidget.onFinish = function (fieldId, paths, multipleFlag) {
    fieldId = fieldId.replace("-n1ed-paths", "");
    fieldId = fieldId.replace("edit-", "");
    var promises = [];
    var dt = new DataTransfer();
    paths.map(function (path, i) {
      var p = new Promise(function (res, rej) {
        fetch(path)
          .then(function (response) {
            return response.blob();
          })
          .then(function (blob) {
            var filename = path.replace(/^.*[\\\/]/, "");
            var file = new File([blob], filename, {
              lastModified: new Date(),
              type: blob.type,
            });
            dt.items.add(file);
            res();
          });
      });
      promises.push(p);
    });
    Promise.all(promises).then(function () {
      if (multipleFlag) {
        document.querySelector(
          "input[name='files[" + fieldId.replace(/-/g, "_") + "][]']"
        ).files = dt.files;
      } else {
        document.querySelector(
          "input[name='files[" + fieldId.replace(/-/g, "_") + "]']"
        ).files = dt.files;
      }

      document
        .querySelector(
          "[data-drupal-selector='edit-" + fieldId + "-upload-button']"
        )
        .dispatchEvent(new Event("mousedown"));
    });
  };
})(Drupal);
