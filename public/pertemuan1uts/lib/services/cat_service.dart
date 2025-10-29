import 'dart:convert';

import 'package:flutter_application_1/model/cat_model.dart';
import 'package:http/http.dart' as http;

class CatService {
  static String baseApiURL = "https://catfact.ninja/breeds";

  //method untuk fetch/get data
  static Future<List<CatModel>> fetchCatData() async {
    final response = await http.get(Uri.parse(baseApiURL));
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      List catsData = data['data'];
      return catsData.map((cat) => CatModel.fromJson(cat)).toList();
    } else {
      throw Exception("Gagal Get Data API");
    }
  }
}
