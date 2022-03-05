/**
 * @file
 * The problem: CKEditor loads longer with N1ED and we need to show this
 * loading process.
 *
 * We can not implement showing starting of loading as a CKEditor plugin,
 * because any of plugins is loaded too late to show the progress,
 * so we will attach new behaviour for "Drupal.editorAttach" call and add
 * the placeholder right when we just try to load CKEditor. The new div
 * with class "n1ed_loading" will be removed by N1ED after CKEditor instance
 * is ready.
 *
 * This loading progress will be applied to CKEditor powered up with N1ED only
 * and will not affect to any other CKEditor instances (like comment forms).
 */

(function () {
  var originalFunc = Drupal.editorAttach;

  Drupal.editorAttach = function (el, format) {
    if (format.editor === "ckeditor") {
      if (
        !(
          !format.editorSettings ||
          !format.editorSettings.extraPlugins ||
          format.editorSettings.extraPlugins.indexOf("N1EDEco") === -1 ||
          format.editorSettings.enableN1EDEcoSystem == "false"
        )
      ) {
        if (document.querySelector("#comment-form")) {
          setTimeout(() => {
            let evt = document.createEvent("HTMLEvents");
            evt.initEvent("change", false, true);
            let element = document
              .querySelector("#comment-form")
              .parentElement.querySelector(".form-select");
            if (element) {
              element.value = drupalSettings.N1EDFreeFormat
                ? drupalSettings.N1EDFreeFormat
                : "basic_html";
              element.dispatchEvent(evt);
            }
          }, 1);
        } else {
          let elStyle = document.createElement("style");
          document.getElementsByTagName("head")[0].appendChild(elStyle);
          elStyle.innerHTML =
            ".n1ed_loading {" +
            "    font-weight: bold;" +
            "    display: flex;" +
            "    justify-content: center;" +
            "    align-items: center;" +
            "    height: 200px;" +
            "    border: 1px solid #CCC;" +
            "}" +
            ".n1ed_loading img {" +
            "    margin-right: 20px;" +
            "}" +
            "" +
            ".n1ed_loading + .form-textarea-wrapper {" +
            "    display: none !important;" +
            "}";

          if (el.parentElement) {
            var elParent = el.parentElement;

            var elLoading = document.createElement("div");
            elLoading.className = "n1ed_loading";
            var urlImage =
              window.drupalSettings.path.baseUrl +
              "modules/n1ed/js/skin/n1theme/wait.svg";
            elLoading.innerHTML =
              '<img src="' + urlImage + '"/> Editor is loading...';
            elParent.parentElement.insertBefore(elLoading, elParent);
          }
        }
      }
    }

    originalFunc.call(Drupal.editorAttach, el, format);
  };
})();
