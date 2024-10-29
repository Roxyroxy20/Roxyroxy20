import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      debugShowCheckedModeBanner: false,
      home: HomePage(),
    );
  }
}

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  // ignore: library_private_types_in_public_api
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final TextEditingController _num1Controller = TextEditingController();
  final TextEditingController _num2Controller = TextEditingController();
  String _result = '0';

  void _addNumbers() {
    double num1 = double.tryParse(_num1Controller.text) ?? 0.0;
    double? num2 = double.tryParse(_num2Controller.text);

    if (_num1Controller.text.isEmpty) {
      setState(() {
        _result = 'Error: fill in 1st num!';
      });
    } else if (_num2Controller.text.isEmpty) {
      setState(() {
        _result = 'Error: fill in 2nd num!';
      });
    } else {
      setState(() {
        _result = (num1 + num2!).toString();
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color.fromARGB(255, 138, 163, 229),
        title: const Text('ROXANNE APP'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: <Widget>[
            const SizedBox(height: 20.0),
            Text(
              'Result: $_result',
              style: const TextStyle(fontSize: 24),
            ),
            TextField(
              controller: _num1Controller,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: 'Enter First number',
              ),
            ),
            const SizedBox(height: 16.0),
            TextField(
              controller: _num2Controller,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: 'Enter second number',
              ),
            ),
            const SizedBox(height: 20.0),
            GestureDetector(
              onTap: _addNumbers,
              child: const Text('Add'),
            ),
          ],
        ),
      ),
    );
  }
}
