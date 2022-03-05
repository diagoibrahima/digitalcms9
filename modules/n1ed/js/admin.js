/**
 * @file
 * 'n1ed' plugin admin behavior.
 */
(function () {
  "use strict";

  var elInputIsN1EDEnabled;

  var elCheckBoxHtmlFilter;
  var isHtmlFilterInitiallyEnabled;

  var elCheckBoxPlainFilter;
  var isPlainFilterInitiallyEnabled;

  function isN1EDCurrentlyEnabled() {
    return elInputIsN1EDEnabled.value !== "false";
  }

  function getCurrentApiKey() {
    return window.drupalSettings.n1edApiKey;
  }

  function getCurrentToken() {
    return window.drupalSettings.n1edToken;
  }

  function onChange(
    isEnabled,
    apiKey,
    token,
    doCommitApiKey,
    onCommitApiKeyFinished
  ) {
    window.drupalSettings.n1edApiKey = apiKey;
    window.drupalSettings.n1edToken = token;

    if (elCheckBoxHtmlFilter) {
      if (isEnabled) {
        elCheckBoxHtmlFilter.disabled = true;
        elCheckBoxHtmlFilter.checked = false;
      } else {
        elCheckBoxHtmlFilter.disabled = false;
        elCheckBoxHtmlFilter.checked = isHtmlFilterInitiallyEnabled;
      }
    }

    if (elCheckBoxPlainFilter) {
      if (isEnabled) {
        elCheckBoxPlainFilter.disabled = true;
        elCheckBoxPlainFilter.checked = false;
      } else {
        elCheckBoxPlainFilter.disabled = false;
        elCheckBoxPlainFilter.checked = isPlainFilterInitiallyEnabled;
      }
    }

    elInputIsN1EDEnabled.value = isEnabled ? "true" : "false";
  }

  function getCookie(name) {
    var a = document.cookie.match("(^|;)\\s*" + name + "\\s*=\\s*([^;]+)");
    return a ? a.pop() : null;
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

    req.open("GET", window.drupalSettings.path.baseUrl + "session/token", true);
    req.send();
  }

  if (!window.n1edEcoControlPanelLoaded) {
    elInputIsN1EDEnabled = document.querySelector(
      '[data-n1ed-eco-param-name="enableN1EDEcoSystem"]'
    );

    elCheckBoxHtmlFilter = document.querySelector(
      ".js-form-item-filters-filter-html-status > input"
    );
    isHtmlFilterInitiallyEnabled =
      elCheckBoxHtmlFilter && elCheckBoxHtmlFilter.checked;

    elCheckBoxPlainFilter = document.querySelector(
      ".js-form-item-filters-filter-html-escape-status > input"
    );
    isPlainFilterInitiallyEnabled =
      elCheckBoxPlainFilter && elCheckBoxPlainFilter.checked;

    // For updating HTML filter checkbox
    onChange(isN1EDCurrentlyEnabled(), getCurrentApiKey(), getCurrentToken());

    window.n1edEcoControlPanelLoaded = true;

    var elFieldSet = document.getElementById("editor-settings-wrapper");
    var elConf = document.createElement("div");
    elConf.setAttribute(
      "style",
      "border: 1px solid #c0c0c0; border-radius: 3px;padding: 70px; display: flex; justify-content: center; align-items: center; background-color: #fcfcfa"
    );

    elConf.innerHTML =
      '<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="16px" height="16px" viewBox="0 0 128 128" xml:space="preserve"><g><path d="M75.4 126.63a11.43 11.43 0 0 1-2.1-22.65 40.9 40.9 0 0 0 30.5-30.6 11.4 11.4 0 1 1 22.27 4.87h.02a63.77 63.77 0 0 1-47.8 48.05v-.02a11.38 11.38 0 0 1-2.93.37z" fill="#007FFF"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="800ms" repeatCount="indefinite"></animateTransform></g></svg>' +
      '<div style="margin-left:10px">Loading N1ED control panel...</div>';

    elFieldSet.parentElement.insertBefore(elConf, elFieldSet);

    var elScript = document.createElement("script");

    // Notice about cookies: developers use it to specify debug server to use,
    // all other users will use old known n1ed.com address
    var prefix = getCookie("N1ED_PREFIX");
    elScript.src =
      "//" + (prefix ? prefix + "." : "") + "n1ed.com/js/n1ed-cms-conf-3.js";

    elScript.addEventListener("load", function () {
      elConf.setAttribute("style", "");
      elConf.innerHTML = "";

      window.attachN1EDCmsConf({
        el: elConf,
        isSelfHosted: window.drupalSettings.selfHostedN1ED == 1,
        urlSelfHostedHandler:
          window.drupalSettings.path.baseUrl +
          "admin/config/n1ed/selfHostedHandler",
        urlSelfHostedHandler__CSRF: getCSRFToken,
        urlSetApiKeyAndToken:
          window.drupalSettings.path.baseUrl + "admin/config/n1ed/setApiKey",
        urlSetApiKeyAndToken__CSRF: getCSRFToken,
        apiKey: getCurrentApiKey(),
        token: getCurrentToken(),
        editorName: "ckeditor",
        integration: "drupal8",
        isCheckBoxN1EDEcoEnabledVisible: true,
        checkBoxN1EDEcoEnabledTitle: "Enable for this text format",
        checkBoxN1EDEcoEnabledValue: isN1EDCurrentlyEnabled(),
        onN1EDEcoEnabledChange: function (value, onFinished) {
          onChange(value, getCurrentApiKey(), getCurrentToken());
          onFinished(null);
        },
        onApiKeyChange: function (apiKey, token) {
          onChange(isN1EDCurrentlyEnabled(), apiKey, token);
        },
        onToolbarChange: function (
          isAutoToolbar,
          allManualButtons,
          availableManualButtons,
          autoToolbars
        ) {
          for (var i = 0; i < allManualButtons.length; i++) {
            var manualButton = allManualButtons[i];
            var isVisible =
              !isAutoToolbar &&
              !!availableManualButtons.find(
                (b) => b.name === manualButton.name
              );
            var elBtn = document.querySelector(
              "[data-drupal-ckeditor-button-name='" + manualButton.name + "']"
            );
            if (elBtn) {
              elBtn.style.display = isVisible ? null : "none";
              const CLASS_TITLE = "cke_button_label";
              var elTitle = elBtn.querySelector("span." + CLASS_TITLE);
              if (manualButton.title && manualButton.title.length > 0) {
                if (!elTitle) {
                  elTitle = document.createElement("span");
                  elTitle.className = CLASS_TITLE + " cke_button__source_label";
                  elTitle.style = "cursor:inherit";
                  var elIcon = elBtn.querySelector(".cke_button_icon");
                  elIcon.parentElement.insertBefore(
                    elTitle,
                    elIcon.nextElementSibling
                  );
                }
                elTitle.textContent = manualButton.title;
              } else {
                if (elTitle) elTitle.parentElement.removeChild(elTitle);
              }
            }
          }

          var elAutoToolbar = document.querySelector(".n1ed-toolbar-auto");
          if (isAutoToolbar) {
            if (!elAutoToolbar) {
              elAutoToolbar = document.createElement("div");
              elAutoToolbar.className = "n1ed-toolbar-auto";
              var elToolbar = document.querySelector(".ckeditor-toolbar");
              elToolbar.appendChild(elAutoToolbar);
            }

            elAutoToolbar.innerHTML = "";
            var elUl = document.createElement("ul");
            elUl.className = "ckeditor-active-toolbar-configuration";
            elAutoToolbar.appendChild(elUl);

            var funcAddToolbarLine = function (toolbarLine) {
              var elToolbarLine1 = document.createElement("li");
              elToolbarLine1.className = "n1ed-ckeditor-row";
              elUl.appendChild(elToolbarLine1);

              var elToolbarLine2 = document.createElement("ul");
              elToolbarLine2.className = "clearfix";
              elToolbarLine1.appendChild(elToolbarLine2);

              var elToolbarLine3 = document.createElement("li");
              elToolbarLine3.className = "ckeditor-toolbar-group";
              elToolbarLine2.appendChild(elToolbarLine3);

              var elToolbarLine4 = document.createElement("ul");
              elToolbarLine4.className =
                "ckeditor-buttons ckeditor-toolbar-group-buttons";
              elToolbarLine3.appendChild(elToolbarLine4);

              for (var i = 0; i < toolbarLine.length; i++) {
                var button = toolbarLine[i];
                if (button.type && button.type === "separator") {
                  var elBtn = document.createElement("li");
                  elBtn.className =
                    "ckeditor-button-separator ckeditor-multiple-button";
                  elBtn.style = "width: 1px; height: 25px";
                  elToolbarLine4.appendChild(elBtn);
                } else {
                  var elBtn = document.querySelector(
                    "[data-drupal-ckeditor-button-name='" + button.name + "']"
                  );
                  if (elBtn) {
                    elBtn = elBtn.cloneNode(true);
                    elBtn.style.display = null;
                    elToolbarLine4.appendChild(elBtn);
                  }
                }
              }
            };

            for (var i = 0; i < autoToolbars.length; i++) {
              var toolbarLine = autoToolbars[i];
              funcAddToolbarLine(toolbarLine);
            }

            var elAutoToolbarHover = document.createElement("div");
            elAutoToolbarHover.className = "n1ed-toolbar-auto__hover";
            elAutoToolbar.appendChild(elAutoToolbarHover);

            var elAutoToolbarHoverTitle = document.createElement("span");
            elAutoToolbarHoverTitle.textContent = "Configure N1ED toolbar";
            elAutoToolbarHover.appendChild(elAutoToolbarHoverTitle);
            elAutoToolbarHover.addEventListener("click", function () {
              window.cmsConfCallToolbarConfigurationDialog();
            });
          } else {
            if (elAutoToolbar)
              elAutoToolbar.parentElement.removeChild(elAutoToolbar);
          }
        },
      });
      var elFmCheckbox = document.createElement("input");
      elFmCheckbox.setAttribute("type", "checkbox");
      elFmCheckbox.style =
        "float: left; display: block; margin-top: 3px; margin-right: 10px;";
      var elFmLabel = document.createElement("label");
      elFmCheckbox.checked = window.drupalSettings.useFlmngrOnFileFields;
      elFmLabel.innerText = "Use Flmngr for file and image fields";
      elFmLabel.appendChild(elFmCheckbox);
      elFmCheckbox.addEventListener("change", function () {
        fetch(
          window.drupalSettings.path.baseUrl +
            "admin/config/n1ed/toggleUseFlmngrOnFileFields",
          {
            method: "POST",
            body: JSON.stringify({
              useFlmngrOnFileFields: elFmCheckbox.checked,
            }),
          }
        );
      });

      elConf.appendChild(elFmLabel);
    });
    elScript.addEventListener("error", function () {
      elConf.innerHTML =
        '<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" width="12" height="12"><path fill="#fe5c4b" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>' +
        '<div style="margin-left:10px">Unable to load N1ED configuration panel. Please try to reload page.</div>';
    });

    var elBody = document.querySelector("body");
    elBody.appendChild(elScript);
  }
})();
