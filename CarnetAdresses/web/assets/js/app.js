var monApplication = angular.module("mon-application", []);

monApplication.config (function ($interpolateProvider) {
	$interpolateProvider.startSymbol ("{[{").endSymbol("}]}") ;
}) ;

monApplication.controller("monControleur", function($scope, $http) {
	$http.get("http://localhost:8000/utilisateurs/all").success(function(reponse) {
		$scope.utilisateurs = reponse;
	});
	setInterval(function() {
		$http.get("http://localhost:8000/utilisateurs/all").success(
				function(reponse) {
					$scope.utilisateurs = reponse;
				});
	}, 5000);
	$scope.ajouter = function() {
		$http.get("http://localhost:8000/utilisateurs?nom=" + $scope.nom + "&prenom=" + $scope.prenom + "&mail=" + $scope.mail + "&adresse=" + $scope.adresse + "&tel=" + $scope.tel + "&siteWeb=" + $scope.siteWeb)
		.success(function() {
			$scope.nom = "";
			$scope.prenom = "";
			$scope.mail="" ;
			$scope.adresse="" ;
			$scope.tel = "";
			$scope.siteWeb="" ;
			$scope.ajoutContactForm.$setPristine();
		});
	}
	$scope.selectionner = function(idUtilisateur) {
		$http.get("http://localhost:8000/utilisateurs/retrieve/" + idUtilisateur)
				.success(function(reponse) {
					$scope.id = reponse.id;
					$scope.nomM = reponse.nom;
					$scope.prenomM = reponse.prenom;
					$scope.mailM=reponse.mail ;
					$scope.adresseM=reponse.adresse ;
					$scope.telM = reponse.tel ;
					$scope.siteWebM=reponse.siteWeb ;
					$scope.existeModification = true;
				});
	}
	$scope.modifier = function() {
		$http.get("http://localhost:8000/utilisateurs/update/" + $scope.id + "?nom=" + $scope.nomM + "&prenom=" + $scope.prenomM + "&mail=" + $scope.mailM + "&adresse=" + $scope.adresseM + "&tel=" + $scope.telM + "&siteWeb=" + $scope.siteWebM)
		.success(function() {
			$scope.id = "";
			$scope.nomM = "";
			$scope.prenomM = "";
			$scope.mailM="" ;
			$scope.adresseM="" ;
			$scope.telM = "";
			$scope.siteWebM="" ;
			$scope.modifContactForm.$setPristine();
			$scope.existeModification = false;
		});
	}
	$scope.supprimer = function(idUtilisateur) {
		var vb = confirm("Voulez-vous vraiment supprimer le contact # "
				+ idUtilisateur + " ?");
		if (vb)
			$http
					.get("http://localhost:8000/utilisateurs/delete/"
							+ idUtilisateur).success (function () {
								$scope.existeModification=false ;
							}) ;
	}
});