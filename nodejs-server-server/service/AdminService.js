'use strict';


/**
 * Add Admin
 * Add Admin
 *
 * body Body_1  (optional)
 * returns Admin
 **/
exports.adminAdminAddPOST = function(body) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
      "password" : "password",
      "updated_at" : "updated_at",
      "name" : "name",
      "created_at" : "created_at",
      "id" : 0,
      "email" : "email"
    };
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * List Admin with pagination
 * get list of admin with pagination
 *
 * page Integer page number (optional)
 * per_page Integer per page (optional)
 * s String search (optional)
 * returns inline_response_200_1
 **/
exports.adminAdminGET = function(page,per_page,s) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
      "first_page_url" : "first_page_url",
      "path" : "path",
      "per_page" : 1,
      "total" : 5,
      "data" : [ {
        "password" : "password",
        "updated_at" : "updated_at",
        "name" : "name",
        "created_at" : "created_at",
        "id" : 0,
        "email" : "email"
      }, {
        "password" : "password",
        "updated_at" : "updated_at",
        "name" : "name",
        "created_at" : "created_at",
        "id" : 0,
        "email" : "email"
      } ],
      "last_page" : 6,
      "last_page_url" : "last_page_url",
      "next_page_url" : "next_page_url",
      "to" : "to",
      "prev_page_url" : "prev_page_url",
      "current_page" : 0
    };
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * Delete Admin
 * Delete Admin
 *
 * id Integer
 * body Body_3  (optional)
 * page Integer page number (optional)
 * per_page Integer per page (optional)
 * s String search (optional)
 * returns inline_response_200_1
 **/
exports.adminAdminIdDeletePOST = function(id,body,page,per_page,s) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
      "first_page_url" : "first_page_url",
      "path" : "path",
      "per_page" : 1,
      "total" : 5,
      "data" : [ {
        "password" : "password",
        "updated_at" : "updated_at",
        "name" : "name",
        "created_at" : "created_at",
        "id" : 0,
        "email" : "email"
      }, {
        "password" : "password",
        "updated_at" : "updated_at",
        "name" : "name",
        "created_at" : "created_at",
        "id" : 0,
        "email" : "email"
      } ],
      "last_page" : 6,
      "last_page_url" : "last_page_url",
      "next_page_url" : "next_page_url",
      "to" : "to",
      "prev_page_url" : "prev_page_url",
      "current_page" : 0
    };
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * show an admin
 * show an admin
 *
 * id Integer
 * returns Admin
 **/
exports.adminAdminIdGET = function(id) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
      "password" : "password",
      "updated_at" : "updated_at",
      "name" : "name",
      "created_at" : "created_at",
      "id" : 0,
      "email" : "email"
    };
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * Update Admin
 * Update Admin
 *
 * id Integer
 * body Body_2  (optional)
 * returns Admin
 **/
exports.adminAdminIdUpdatePOST = function(id,body) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
      "password" : "password",
      "updated_at" : "updated_at",
      "name" : "name",
      "created_at" : "created_at",
      "id" : 0,
      "email" : "email"
    };
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * get list of admin with pagination
 *
 * body Body  (optional)
 * returns inline_response_200
 **/
exports.authAdminPOST = function(body) {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
      "admin" : {
        "password" : "password",
        "updated_at" : "updated_at",
        "name" : "name",
        "created_at" : "created_at",
        "id" : 0,
        "email" : "email"
      },
      "token" : "token"
    };
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}

