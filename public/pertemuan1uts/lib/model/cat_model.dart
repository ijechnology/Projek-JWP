class CatModel {
  final String breed;
  final String country;
  final String origin;
  final String coat;
  final String pattern;

  CatModel({
    required this.breed,
    required this.country,
    required this.origin,
    required this.coat,
    required this.pattern,
  });

  factory CatModel.fromJson(Map<String, dynamic> jsonData) {
    return CatModel(
      breed: jsonData['breed'] ?? "",
      country: jsonData['country'] ?? "",
      origin: jsonData['origin'] ?? "",
      coat: jsonData['coat'] ?? "",
      pattern: jsonData['pattern'] ?? "",
    );
  }
}
