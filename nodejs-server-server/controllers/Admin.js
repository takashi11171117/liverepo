'use strict';

var utils = require('../utils/writer.js');
var Admin = require('../service/AdminService');

module.exports.adminAdminAddPOST = function adminAdminAddPOST (req, res, next) {
  var body = req.swagger.params['body'].value;
  Admin.adminAdminAddPOST(body)
    .then(function (response) {
      if (body.email === "") {
        var responsePayload = utils.respondWithCode(422, {
          "message": "The given data was invalid.",
          "errors": {
            'name': ['required'],
            'email': ['required'],
            'password': ['required']
          }
        });
        utils.writeJson(res, responsePayload);
      } else {
        utils.writeJson(res, response);
      }
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.adminAdminGET = function adminAdminGET (req, res, next) {
  var page = req.swagger.params['page'].value;
  var per_page = req.swagger.params['per_page'].value;
  var s = req.swagger.params['s'].value;
  Admin.adminAdminGET(page,per_page,s)
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.adminAdminIdDeletePOST = function adminAdminIdDeletePOST (req, res, next) {
  var id = req.swagger.params['id'].value;
  var body = req.swagger.params['body'].value;
  var page = req.swagger.params['page'].value;
  var per_page = req.swagger.params['per_page'].value;
  var s = req.swagger.params['s'].value;
  Admin.adminAdminIdDeletePOST(id,body,page,per_page,s)
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.adminAdminIdGET = function adminAdminIdGET (req, res, next) {
  var id = req.swagger.params['id'].value;
  Admin.adminAdminIdGET(id)
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.adminAdminIdUpdatePOST = function adminAdminIdUpdatePOST (req, res, next) {
  var id = req.swagger.params['id'].value;
  var body = req.swagger.params['body'].value;
  Admin.adminAdminIdUpdatePOST(id,body)
    .then(function (response) {
      if (body.email === "") {
        var responsePayload = utils.respondWithCode(422, {
          "message": "The given data was invalid.",
          "errors": {
            'name': ['required'],
            'email': ['required'],
            'password': ['required']
          }
        });
        utils.writeJson(res, responsePayload);
      } else {
        utils.writeJson(res, response);
      }
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.authAdminPOST = function authAdminPOST (req, res, next) {
  var body = req.swagger.params['body'].value;
  Admin.authAdminPOST(body)
    .then(function (response) {
      if (body.email === "") {
        var responsePayload = utils.respondWithCode(401, {'error': 'a'});
        utils.writeJson(res, responsePayload);
      } else {
        utils.writeJson(res, response);
      }
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
