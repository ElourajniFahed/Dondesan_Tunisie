
$('.carousel').carousel({
  interval: 2000
})
$(document).ready(function(){
  $("span.icon").click(function() {
      $(".nav-list").slideToggle()
  });
  $(window).scroll(function()
  {
     var sc=$(this).scrollTop();
      if(sc>100)
      {
          $("header").addClass("stiky");
      }
      else
          $("header").removeClass("stiky");
  });

});
function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}

var nameSpace = {};

nameSpace.currentFrame = -1;
nameSpace.wizardContainer = $(".wizard-contents");
nameSpace.wizardSteps = [
  {
    question: "What is your name?",
    button_label: "Next Question" 
  },
  {
    question: "What are your qualifications?",
    button_label: "Next Question"
  },
  {
    question: "Where do you see yourself in 5 years?",
    button_label: "Summary"
  }
];

nameSpace.answers = [];

nameSpace.renderFrame = function () {
  var step = nameSpace.wizardSteps[nameSpace.currentFrame];
  var liveQuestionTemplate = $(document.importNode(document.querySelector('#question_template').content, true));
  liveQuestionTemplate.find(".question, .question-label").html(step.question);
  liveQuestionTemplate.find(".button-label").html(step.button_label);
  nameSpace.wizardContainer.html(liveQuestionTemplate);
  $('#answer').focus();
  nameSpace.currentFrame == 0 ? $(".back-button").hide() : '';
};

nameSpace.saveAnswer = function () {
  var answer = $("#answer").val();
  if (answer) {
    nameSpace.answers[nameSpace.currentFrame] = answer;
  }
};

nameSpace.renderSummary = function () {
  var liveSummaryTemplate = $(document.importNode(document.querySelector('#summary_template').content, true));
  var summaryList = liveSummaryTemplate.find(".summary");
  nameSpace.wizardSteps.forEach(function (step, index) {
    var entry = "<li><span class='summary-question'>Q: " + step.question + "</span><span class='summary-answer'>A: " + nameSpace.answers[index] + "</span></li>";
    summaryList.append(entry);
  });
  nameSpace.wizardContainer.html(liveSummaryTemplate);
};

nameSpace.nextFrame = function () {
  nameSpace.saveAnswer();
  nameSpace.currentFrame++;
  if (nameSpace.currentFrame != nameSpace.wizardSteps.length) {
    nameSpace.renderFrame();
  } else {
    nameSpace.renderSummary();
  }
};

nameSpace.goBack = function () {
  nameSpace.currentFrame--;
  nameSpace.renderFrame();
};
$(document).ready(function() {
  $('#contact_form').bootstrapValidator({
    // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      first_name: {
        validators: {
          stringLength: {
            min: 2,
          },
          notEmpty: {
            message: 'tapez votre nom'
          }
        }
      },
      last_name: {
        validators: {
          stringLength: {
            min: 2,
          },
          notEmpty: {
            message: 'tapez votre prenom'
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: 'Ptapez votre mail'
          },
          emailAddress: {
            message: 'verifier votre adresse '
          }
        }
      },
      phone: {
        validators: {
          notEmpty: {
            message: 'tapez votre numero'
          },

        }
      },
      cin: {
        validators: {
          stringLength: {
            min: 8,
          },
          notEmpty: {
            message: 'tapez votre cin '
          }
        }
      },

      sang: {
        validators: {
          notEmpty: {
            message: 's il vous plait choisisez votre group sanguin'
          }
        }
      },
      zip: {
        validators: {
          notEmpty: {
            message: 'Please supply your zip code'
          },
          zipCode: {
            country: 'US',
            message: 'Please supply a vaild zip code'
          }
        }
      },
      comment: {
        validators: {
          stringLength: {
            min: 10,
            max: 200,
            message:'tapez au moins 10 caracteres'
          },
          notEmpty: {
            message: 'tapez votre message '
          }
        }
      }
    }
  })
      .on('success.form.bv', function(e) {
        $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
        $('#contact_form').data('bootstrapValidator').resetForm();

        // Prevent form submission
        e.preventDefault();

        // Get the form instance
        var $form = $(e.target);

        // Get the BootstrapValidator instance
        var bv = $form.data('bootstrapValidator');

        // Use Ajax to submit form data
        $.post($form.attr('action'), $form.serialize(), function(result) {
          console.log(result);
        }, 'json');
      });
});
/*
 Hielo by TEMPLATED
 templated.co @templatedco
 Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
 */

