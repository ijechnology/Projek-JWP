import 'package:flutter/material.dart';
import 'package:flutter_application_1/services/cat_service.dart';

class CatPage extends StatelessWidget {
  const CatPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Kucing")),
      body: FutureBuilder(
        future: CatService.fetchCatData(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }
          final cats = snapshot.data!;
          return Column(
            children: [
              Text(cats[0].breed),
              Text(cats[0].coat),
              Text(cats[0].country),
              Text(cats[0].origin),
              Text(cats[0].pattern),
            ],
          );
        },
      ),
    );
  }
}
